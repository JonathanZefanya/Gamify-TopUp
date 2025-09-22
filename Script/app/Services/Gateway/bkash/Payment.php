<?php

namespace App\Services\Gateway\bkash;

use App\Traits\Bkash;
use Facades\App\Services\BasicService;
use Exception;

class Payment
{
    use Bkash;

    public static function prepareData($deposit, $gateway)
    {
        throw_if(empty($gateway->parameters->app_key ?? "") || empty($gateway->parameters->app_secret ?? ""), "Unable to process with bKash.");

        $_this = new self();
        $token = $_this->getToken($gateway);
        $uri = $_this->getBaseURL($gateway->environment) . "/create";
        $data = array(
            'mode' => '0011',
            'payerReference' => ' ',
            'callbackURL' => route('ipn', ['code' => 'bkash', 'trx' => $deposit->trx_id]),
            'amount' => round($deposit->payable_amount, 2),
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $deposit->trx_id
        );

        $response = $_this->sentHttpRequestToBkash($token, $gateway->parameters->app_key, $uri, $data);

        if ($response->status() == 200) {
            $bkashResponse = json_decode($response->body());
            throw_if(!isset($bkashResponse->bkashURL, $bkashResponse->paymentID), 'Something went wrong while trying pay with bKash. Please contact with author.');

            $deposit->update([
                'payment_id' => $bkashResponse->paymentID
            ]);

            $send['redirect'] = true;
            $send['redirect_url'] = $bkashResponse->bkashURL;
            return json_encode($send);
        }
        throw new Exception("Something went wrong while trying to pay with your bKash.");
    }

    public static function ipn($request, $gateway, $deposit = null, $trx = null, $type = null)
    {
        $_this = new self();
        if (isset($request->status) && $request->status == 'failure') {
            return $_this->updateAndMessage($deposit, 'Failed','Payment Failed due to unknown reason.');
        }

        if (isset($request->status) && $request->status == 'cancel') {
            return $_this->updateAndMessage($deposit, 'Cancelled','Payment cancelled.');
        }
        $executePaymentResponse = $_this->executePayment($request->paymentID, $gateway);

        if (isset($executePaymentResponse->statusCode) && $executePaymentResponse->statusCode != '0000') {
            return $_this->updateAndMessage($deposit, 'Failed',$executePaymentResponse->statusMessage);
        }

        if (isset($executePaymentResponse->message)) {
            $query = $_this->queryPayment($request->paymentID, $gateway);

            if ($query->trxID) {
                BasicService::preparePaymentUpgradation($deposit, $query->trxID, 'bKash Gateway');
                $data['status'] = 'success';
                $data['msg'] = 'Transaction was successful.';
                $data['redirect'] = route('success');
                return $data;
            }
            return $_this->updateAndMessage($deposit, 'Failed', $query->statusMessage);
        }
        BasicService::preparePaymentUpgradation($deposit, $executePaymentResponse->trxID, 'bKash Gateway');

        $data['status'] = 'success';
        $data['msg'] = 'Transaction was successful.';
        $data['redirect'] = route('success');
        return $data;
    }



    public static function refund($deposit, $trxNo, $gateway, $amount)
    {
        $_this = new self();
        throw_if(empty($gateway->parameters->app_key ?? "") || empty($gateway->parameters->app_secret ?? ""), "Unable to process with bKash.");
        $token = $_this->getToken($gateway);

        $uri = $_this->getBaseURL($gateway->environment) . "/payment/refund";
        $data = array(
            'paymentID' => $deposit->payment_id,
            'amount' => $amount,
            'trxID' => $trxNo,
            'sku' => 'sku',
            'reason' => "Requested for refund."
        );
        $response = $_this->sentHttpRequestToBkash($token, $gateway->parameters->app_key, $uri, $data);

        if ($response->status() == 200) {
            $bkashResponse = json_decode($response->body());

            if (!isset($bkashResponse->refundTrxID))
                return [
                    'status' => 'error',
                    'msg' => $bkashResponse->statusMessage ?? 'Something went wrong while trying refund.'
                ];

            return [
                'status' => 'success',
                'msg' => 'refund was successful.',
                'trx_id' => $bkashResponse->refundTrxID
            ];
        }
        throw new Exception("Something went wrong while trying to verify your payment with bKash.");
    }

}
