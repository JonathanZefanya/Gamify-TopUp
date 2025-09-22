<?php

namespace App\Services\Gateway\nagad;

use App\Models\Deposit;
use App\Traits\Nagad;
use Facades\App\Services\BasicService;
use Exception;
use Illuminate\Support\Facades\Http;

class Payment
{
    use Nagad;

    public static function prepareData($deposit, $gateway)
    {
        $_this = new self();
        throw_if(empty($gateway->parameters->merchant_id ?? ""), "Unable to process with nagad.");

        $refNo = $deposit->trx_id;
        $additionalInfo = null;
        $sensitiveData = $_this->generateSensitiveData($gateway->parameters->merchant_id, $refNo);

        $response = Http::withHeaders($_this->headers())
            ->acceptJson()
            ->post($_this->getBaseURL($gateway->environment) . "/check-out/initialize/{$gateway->parameters->merchant_id}/{$refNo}", [
                'accountNumber' => $gateway->parameters->merchant_id,
                'dateTime' => now('Asia/Dhaka')->format('YmdHis'),
                'sensitiveData' => $_this->encryptDataWithPublicKey($gateway, json_encode($sensitiveData)),
                'signature' => $_this->signatureGenerate($gateway, json_encode($sensitiveData))
            ]);

        throw_if($response->status() != 200, "Something went wrong while trying to pay with nagad.");

        $nagadData = json_decode($response->body());

        throw_if(isset($nagadData->reason), "Something went wrong while trying to pay with nagad.");

        throw_if(!$_this->decryptInitialResponse($gateway, $nagadData), "Something went wrong while trying to pay with nagad.");

        $sensitiveOrderData = $_this->generateSensitiveDataOrder($gateway->parameters->merchant_id, $refNo, $deposit->payable_amount_in_base_currency, $deposit->base_currency_charge);

        $completeResponse = Http::withHeaders($_this->headers())
            ->acceptJson()
            ->post($_this->getBaseURL($gateway->environment) . "/check-out/complete/{$_this->PAYMENT_REF_ID}", [
                'sensitiveData' => $_this->encryptDataWithPublicKey($gateway, json_encode($sensitiveOrderData)),
                'signature' => $_this->signatureGenerate($gateway, json_encode($sensitiveOrderData)),
                'merchantCallbackURL' => route('ipn', ['code' => 'nagad', 'trx' => $deposit->trx_id]),
                'additionalMerchantInfo' => (object)$additionalInfo
            ]);

        throw_if($completeResponse->status() != 200, "Something went wrong while trying to initiate payment with nagad.");

        $nagadCompleteData = json_decode($completeResponse->body());

        throw_if(isset($nagadCompleteData->reason), "Something went wrong while trying to initiate payment with nagad.");

        $nagadCompleteData->paymentID = $_this->PAYMENT_REF_ID;

        $deposit->update([
            'payment_id' => $nagadCompleteData->paymentID
        ]);

        $data['redirect'] = true;
        $data['redirect_url'] = $nagadCompleteData->callBackUrl;
        return json_encode($data);
    }


    public static function ipn($request, $gateway, $deposit = null, $trx = null, $type = null)
    {
        $_this = new self();
        if (isset($request->status) && $request->status == 'Failed') {
            return $_this->updateAndMessage($deposit, 'Payment Failed', $request->status, $request->message);
        }

        if (isset($request->status) && $request->status == 'Cancelled') {
            return $_this->updateAndMessage($deposit, 'Payment Cancelled', $request->status, $request->message);
        }

        if (isset($request->status) && $request->status == 'InvalidRequest') {
            return $_this->updateAndMessage($deposit, 'Invalid Request', $request->status, $request->message);
        }

        if (isset($request->status) && $request->status == 'Fraud') {
           return  $_this->updateAndMessage($deposit, 'fraudulent activity', $request->status, $request->message);
        }

        if (isset($request->status) && $request->status == 'Aborted') {
           return $_this->updateAndMessage($deposit, 'Aborted', $request->status, $request->message);
        }

        if (isset($request->status) && $request->status == 'UnknownFailed') {
            return $_this->updateAndMessage($deposit, 'Unknown Failed', $request->status, $request->message);
        }

        $merchantId = $gateway->parameters->merchant_id;

        if (isset($request->status, $request->payment_ref_id, $request->merchant) && $request->status == 'Success' && $request->merchant == $merchantId) {
            $verifyPaymentResponse = $_this->verifyPayment($gateway, $request->payment_ref_id);

            if (isset($verifyPaymentResponse->status, $verifyPaymentResponse->merchantId, $verifyPaymentResponse->paymentRefId, $verifyPaymentResponse->issuerPaymentRefNo, $verifyPaymentResponse->amount) && $verifyPaymentResponse->status == 'Success' && $verifyPaymentResponse->merchantId == $merchantId) {
                BasicService::preparePaymentUpgradation($deposit);
                $data['status'] = strtolower($request->status);
                $data['msg'] = $verifyPaymentResponse->message;
                $data['redirect'] = route('success');
                return $data;
            } else {
                return $_this->updateAndMessage($deposit, 'Unknown Failed', 'Failed', $verifyPaymentResponse->message);
            }
        }
    }


    public function verifyPayment($gateway, $paymentId)
    {
        throw_if(empty($this->getBaseURL($gateway->environment)) || empty($gateway->parameters->merchant_id ?? ""), "Unable to process with nagad.");

        $response = Http::withHeaders($this->headers())
            ->acceptJson()
            ->get($this->getBaseURL($gateway->environment) . "/verify/payment/{$paymentId}");

        if ($response->status() == 200) {
            $nagadResponse = json_decode($response->body());
            return $nagadResponse;
        }

        throw new Exception("Something went wrong while trying to verify your payment with nagad.");
    }

    public static function refund($deposit, $refNo, $gateway, $amount)
    {
        $_this = new self();
        throw_if(empty($_this->getBaseURL($gateway->environment)) || empty($gateway->parameters->merchant_id), "Unable to process with nagad.");

        $sensitiveOrderData = [
            'merchantId' => $gateway->parameters->merchant_id,
            "originalRequestDate" => now('Asia/Dhaka')->format('Ymd'),
            'originalAmount' => $deposit->payable_amount,
            'cancelAmount' => $amount,
            'referenceNo' => $refNo,
            'referenceMessage' => "Requested for refund.",
        ];

        $response = Http::withHeaders($_this->headers())
            ->post($_this->getBaseURL($gateway->environment) . "/purchase/cancel?paymentRefId={$deposit->payment_id}&orderId={$refNo}", [
                "sensitiveDataCancelRequest" => $_this->encryptDataWithPublicKey($gateway, json_encode($sensitiveOrderData)),
                "signature" => $_this->signatureGenerate($gateway, json_encode($sensitiveOrderData))
            ]);

        if ($response->status() == 200) {
            $nagadResponse = json_decode($response->body());
            return json_decode($_this->decryptDataWithPrivateKey($gateway, $nagadResponse->sensitiveData));
        }
        throw new Exception("Something went wrong while trying to verify your payment with nagad.");
    }

}
