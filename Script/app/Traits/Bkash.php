<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Http;

trait Bkash
{
    protected function getBaseURL($mode = "test")
    {
        return $mode == 'test' ? "https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout" : "https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized/checkout";
    }

    protected function sentHttpRequestToBkash($token, $appKey, $uri, $data)
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $token,
            'X-APP-Key' => $appKey,
        ])
            ->acceptJson()
            ->post($uri, $data);
    }

    protected function getToken($gateway)
    {
        throw_if(empty($gateway->parameters->username ?? "") || empty($gateway->parameters->password ?? "") || empty($gateway->parameters->app_key ?? "") || empty($gateway->parameters->app_secret ?? ""), "Unable to process with bKash.");

        $uri = $this->getBaseURL($gateway->environment) . "/token/grant";
        $data = [
            'app_key' => $gateway->parameters->app_key,
            'app_secret' => $gateway->parameters->app_secret,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'username' => $gateway->parameters->username,
            'password' => $gateway->parameters->password,
        ])
            ->acceptJson()
            ->post($uri, $data);

        if ($response->status() == 200) {
            $bkashResponse = json_decode($response->body());
            throw_if(!isset($bkashResponse->id_token), "Something went wrong while trying to pay with bKash.");

            $token = $bkashResponse->id_token;
            return $token;
        }
        throw new Exception("Something went wrong while trying to pay with bKash.");
    }

    public function executePayment($paymentID, $gateway)
    {
        throw_if(empty($gateway->parameters->app_key ?? "") || empty($gateway->parameters->app_secret ?? ""), "Unable to process with bKash.");
        $token = $this->getToken($gateway);
        $uri = $this->getBaseURL($gateway->environment) . "/execute";
        $data = array(
            'paymentID' => $paymentID
        );
        $response = $this->sentHttpRequestToBkash($token, $gateway->parameters->app_key, $uri, $data);

        if ($response->status() == 200) {
            $bkashResponse = json_decode($response->body());
            return $bkashResponse;
        }
        throw new Exception("Something went wrong while trying to verify your payment with bKash.");
    }

    public function queryPayment($paymentID, $gateway)
    {
        throw_if(empty($gateway->parameters->app_key ?? "") || empty($gateway->parameters->app_secret ?? ""), "Unable to process with bKash.");
        $token = $this->getToken($gateway);
        $uri = $this->getBaseURL($gateway->environment) . "/payment/status";
        $data = array(
            'paymentID' => $paymentID
        );
        $response = $this->sentHttpRequestToBkash($token, $gateway->parameters->app_key, $uri, $data);
        if ($response->status() == 200) {
            $bkashResponse = json_decode($response->body());
            return $bkashResponse;
        }
        throw new Exception("Something went wrong while trying to verify your payment with bKash.");
    }

    public function updateAndMessage($deposit, $note, $msg)
    {
        $deposit->update([
            'status' => 3,
            'note' => $note
        ]);
        $data['status'] = 'error';
        $data['msg'] = $msg;
        $data['redirect'] = route('failed');
        return $data;
    }
}
