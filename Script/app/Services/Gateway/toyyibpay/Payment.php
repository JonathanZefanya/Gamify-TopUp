<?php

namespace App\Services\Gateway\toyyibpay;

use App\Models\Deposit;
use App\Traits\ToyyibPay;
use Dflydev\DotAccessData\Data;
use Facades\App\Services\BasicService;
use Exception;
use Illuminate\Support\Facades\Http;

class Payment
{
    use ToyyibPay;

    public static function prepareData($deposit, $gateway)
    {
        throw_if(empty($gateway->parameters->category_code ?? "") || empty($gateway->parameters->secret_key ?? ""), "Unable to process with Toyyib Pay.");
        $_this = new self();
        $data = [
            'userSecretKey' => $gateway->parameters->secret_key,
            'categoryCode' => $gateway->parameters->category_code,
            'billName' => 'Payment for #' . $deposit->trx_id,
            'billDescription' => 'Total amount of order items',
            'billPriceSetting' => 0,
            'billPayorInfo' => 1,
            'billAmount' => round($deposit->payable_amount*100, 2),
            'billReturnUrl' => route('ipn', ['code' => 'toyyibpay', 'trx' => $deposit->trx_id]),
            'billCallbackUrl' => route('ipn', ['code' => 'toyyibpay', 'trx' => $deposit->trx_id]),
            'billExternalReferenceNo' => $deposit->trx_id,
            'billTo' => $deposit->user->firstname . ' ' . $deposit->user->lastname,
            'billEmail' => $deposit->user->email ?? '-',
            'billPhone' => $deposit->user->phone ?? '-',
            'billPaymentChannel' => '2',
            'billContentEmail' => 'Thank you for purchasing our product!',
            'billChargeToCustomer' => '',
        ];

        $uri = $_this->getBaseURL($gateway->environment) . "/index.php/api/createBill";

        $response = Http::asForm()->post($uri, $data);

        if ($response->status() == 200) {
            $tayebPayResponse = json_decode($response->body());

            throw_if(!isset($tayebPayResponse), 'Failed to initiate payment with Toyyib Pay.');

            $deposit->update([
                'payment_id' => $tayebPayResponse[0]->BillCode
            ]);

            $returnData = [
                'redirect' => true,
                'redirect_url' => $_this->getBaseURL($gateway->environment) . '/' . $tayebPayResponse[0]->BillCode
            ];
            return json_encode($returnData);
        }
        throw new Exception("Something went wrong while initiating the payment with Toyyib Pay.");
    }


    public static function ipn($request, $gateway, $deposit = null, $trx = null)
    {
        $_this = new self();
        if ((isset($request->status_id) && $request->status_id == 3) || (isset($request->status) && $request->status == 3)){
            return $_this->updateAndMessage($deposit, 3,'Failed', 'Payment failed.');
        }

        if ((isset($request->status_id) && $request->status_id == 1) || (isset($request->status) && $request->status == 1)){
            $verifyResponse = $_this->verifyPayment($request, $deposit, $gateway);

            if (isset($verifyResponse) && $verifyResponse->billExternalReferenceNo == $deposit->trx_id && $verifyResponse->billpaymentStatus == 1) {
                BasicService::preparePaymentUpgradation($deposit, $verifyResponse->billpaymentInvoiceNo, 'Toyyib Pay Gateway');
                $data['status'] = 'success';
                $data['msg'] = 'Transaction was successful.';
                $data['redirect'] = route('success');
                return $data;
            } else {
                return $_this->updateAndMessage($deposit, 3, 'Unknown Failed', $verifyResponse->msg);
            }
        }
    }


}
