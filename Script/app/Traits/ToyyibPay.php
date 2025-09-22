<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ToyyibPay
{
    protected function getBaseURL($mode = "test")
    {
        return $mode == 'test' ? "https://dev.toyyibpay.com" : "https://api.toyyibpay.com";
    }

    public function verifyPayment($request, $deposit, $gateway)
    {
        throw_if(empty($this->getBaseURL($gateway->environment)) || empty($gateway->parameters->secret_key ?? "") || empty($gateway->parameters->secret_key ?? ""), "Unable to process with Toyyib Pay.");

        $data = [
            'userSecretKey' => $gateway->parameters->secret_key,
            'billCode' => $deposit->payment_id,
        ];

        $uri = $this->getBaseURL($gateway->environment) . "/index.php/api/getBillTransactions";
        $response = Http::asForm()->post($uri, $data);
        $tayebPayResponse = json_decode($response->body());

        if (isset($tayebPayResponse[0]->billpaymentStatus)) {
            return $tayebPayResponse[0];
        }
        throw new \Exception("Failed to verify payment with Toyyib Pay.");
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
