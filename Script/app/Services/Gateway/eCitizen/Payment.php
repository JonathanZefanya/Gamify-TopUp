<?php

namespace App\Services\Gateway\eCitizen;

use App\Models\Deposit;
use Facades\App\Services\BasicService;
use hisorange\BrowserDetect\Exceptions\Exception;
use phpDocumentor\Reflection\Types\This;

class Payment
{
    public static function prepareData(Deposit $deposit, $gateway): string
    {
        if (empty($gateway->parameters->api_client_ID) || empty($gateway->parameters->secret)) {
            throw new \Exception("Unable to process with eCitizen Gateway. Missing API Client ID or Secret.");
        }

        $uri = ($gateway->environment == 'test' ? "https://test.pesaflow.com/PaymentAPI/iframev2.1.php" : "https://account.ecitizen.go.ke");
        $paymentDetails = [
            'apiClientID' => $gateway->parameters->api_client_ID,
            'serviceID' => $gateway->parameters->service_ID,
            'billRefNumber' => $deposit->trx_id,
            'billDesc' => 'Total amount of order items',
            'clientMSISDN' => $deposit->user->phone,
            'clientIDNumber' => $deposit->user->id,
            'clientName' => $deposit->user->firstname && $deposit->user->lastname != '' ? $deposit->user->firstname . ' ' . $deposit->user->lastname : $deposit->user->username,
            'clientEmail' => $deposit->user->email ?? '',
            'notificationURL' => '',
            'pictureURL' => "false",
            'callBackURLOnSuccess' => route('ipn', ['code' => 'eCitizen', 'trx' => $deposit->trx_id]),
            'currency' => $deposit->payment_method_currency,
            'amountExpected' => round($deposit->payable_amount, 2),
            'format' => "html",
            'sendSTK' => "false",
            'secret' => $gateway->parameters->secret,
            'success_url' => route('success'),
            'cancel_url' => twoStepPrevious($deposit),
            'additional_info' => "Payment for order ID: {$deposit->trx_id}",
        ];

        $data_string = implode('', [
            $paymentDetails['apiClientID'],
            $paymentDetails['amountExpected'],
            $paymentDetails['serviceID'],
            $paymentDetails['clientIDNumber'],
            $paymentDetails['currency'],
            $paymentDetails['billRefNumber'],
            $paymentDetails['billDesc'],
            $paymentDetails['clientName'],
            $paymentDetails['secret']
        ]);
        $secure_hash = base64_encode(hash_hmac('sha256', $data_string, $gateway->parameters->key, false));

        $paymentDetails['secureHash'] = $secure_hash;

        $send['url'] = $uri;
        $send['method'] = 'POST';
        $send['view'] = 'redirect';
        $send['val'] = $paymentDetails;
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $deposit = null, $trx = null, $type = null)
    {

        $_this = new self();
        $deposit = Deposit::where('trx_id', $request->order_id)->orderBy('id', 'desc')->first();
        if (!$deposit) {
            return response()->json(['error' => 'Deposit not found']);
        }

        if ($request->status == 500) {
            return $_this->updateAndMessage($deposit, 3, 'Failed', 'Payment failed.');
        }

        $data_string = implode('', [
            $gateway->parameters->api_client_ID,
            round($request->Amount, 2),
            $gateway->parameters->service_ID,
            $request->order_id,
            $request->currency,
            $request->order_id,
            'Total amount of order items',
            trim(($deposit->user->firstname ?? 'Unknown') . ' ' . ($deposit->user->lastname ?? 'User')),
            $gateway->parameters->secret
        ]);

        $generated_hash = base64_encode(hash_hmac('sha256', $data_string, $gateway->parameters->key, false));

        if (!hash_equals($generated_hash, $request->secure_hash)) {
            return response()->json(['error' => 'Invalid payment details']);
        }

        if ($deposit->status == 0) {
            BasicService::preparePaymentUpgradation($deposit);
            $data['status'] = 'success';
            $data['msg'] = 'Transaction was successful.';
            $data['redirect'] = route('success');
            return response()->json($data);
        }
        return response()->json(['error' => 'Invalid payment details or transaction already processed']);
    }

    protected function updateAndMessage($deposit, $status, $note, $msg)
    {
        $deposit->update([
            'status' => $status,
            'note' => $note
        ]);
        return [
            'status' => 'error',
            'msg' => $msg,
            'redirect' => route('failed')
        ];
    }
}
