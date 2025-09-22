<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait Nagad
{
    protected $PAYMENT_REF_ID;
    protected $CHALLANGE;


    protected function getBaseURL($mode = "test")
    {
        return $mode == 'test' ? "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs" : "https://api.mynagad.com/api/dfs/";
    }

    protected function headers()
    {
        return [
            "Content-Type" => "application/json",
            "X-KM-IP-V4" => request()->ip(),
            "X-KM-Api-Version" => "v-0.2.0",
            "X-KM-Client-Type" => "PC_WEB"
        ];
    }

    protected function generateRandomString($length = 40)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function generateSensitiveData($merchantId, $trx_id): array
    {
        return [
            'merchantId' => $merchantId,
            'datetime' => now('Asia/Dhaka')->format('YmdHis'),
            'orderId' => $trx_id,
            'challenge' => $this->generateRandomString()
        ];
    }

    protected function generateSensitiveDataOrder($merchantId, $orderId, $amount, $charge): array
    {
        return [
            'merchantId' => $merchantId,
            'orderId' => $orderId,
            'currencyCode' => '050',        //050 = BDT
            'amount' => $amount,
            'charge' => $charge,
            'challenge' => $this->CHALLANGE
        ];
    }

    public function signatureGenerate($gateway, $data)
    {
        $merchantPrivateKey = $gateway->parameters->private_key;
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
        openssl_sign($data, $signature, $private_key, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }

    public function decryptDataWithPrivateKey($gateway, $crypttext)
    {
        $merchantPrivateKey = $gateway->parameters->private_key;
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
        openssl_private_decrypt(base64_decode($crypttext), $plain_text, $private_key);
        return $plain_text;
    }

    protected function decryptInitialResponse($gateway, object $response): bool
    {
        $plainResponse = json_decode($this->DecryptDataWithPrivateKey($gateway, $response->sensitiveData));

        if (isset($plainResponse->paymentReferenceId) && isset($plainResponse->challenge)) {
            $this->PAYMENT_REF_ID = $plainResponse->paymentReferenceId;
            $this->CHALLANGE = $plainResponse->challenge;
            return true;
        }
        return false;
    }

    public function encryptDataWithPublicKey($gateway, $data)
    {
        $pgPublicKey = $gateway->parameters->public_key;
        $public_key = "-----BEGIN PUBLIC KEY-----\n" . $pgPublicKey . "\n-----END PUBLIC KEY-----";
        $key_resource = openssl_get_publickey($public_key);
        openssl_public_encrypt($data, $crypttext, $key_resource);
        return base64_encode($crypttext);
    }

    public function updateAndMessage($deposit, $note, $status, $msg)
    {
        $deposit->update([
            'status' => 3,
            'note' => $note
        ]);
        $data['status'] = strtolower($status);
        $data['msg'] = $msg;
        $data['redirect'] = route('failed');
        return $data;
    }
}
