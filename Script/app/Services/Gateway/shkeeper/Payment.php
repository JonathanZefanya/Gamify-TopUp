<?php

namespace App\Services\Gateway\shkeeper;

use App\Models\Deposit;
use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($deposit, $gateway)
    {
        $apiKey = $gateway->parameters->api_key ?? '';
        $hostedUrl = $gateway->parameters->hosted_url ?? '';
        $url = rtrim($hostedUrl, '/') . "/api/v1/{$deposit->payment_crypto_currency}/payment_request";

        $postParams = [
            "external_id" => $deposit->trx_id,
            "fiat" => "USD",
            "amount" => round($deposit->payable_amount, 2),
            "callback_url" => route('ipn', [$gateway->code, $deposit->trx_id])
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParams));

        $headers = array();
        $headers[] = 'X-Shkeeper-Api-Key: ' . $apiKey;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $res = json_decode($result);

        if ($res && $res->status == 'success') {
            $deposit->btc_amount = $res->amount;
            $deposit->btc_wallet = $res->wallet;
            $deposit->save();
        }

        $send['amount'] = $deposit->btc_amount;
        $send['sendto'] = $deposit->btc_wallet;
        $send['img'] = BasicService::cryptoQR($deposit->btc_wallet, $deposit->btc_amount, $deposit->payment_crypto_currency);
        $send['currency'] = $deposit->payment_crypto_currency ?? 'BTC';
        $send['view'] = 'crypto';
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $deposit = null, $trx = null, $type = null)
    {
        $apiKey = $gateway->parameters->api_key ?? '';
        $hostedUrl = $gateway->parameters->hosted_url ?? '';
        $url = rtrim($hostedUrl, '/') . "/api/v1/invoices/{$deposit->trx_id}";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'X-Shkeeper-Api-Key: ' . $apiKey;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $res = json_decode($result);

        if ($res && $res->status == 'success' && ($res->invoices[0]->status == 'PAID' || $res->invoices[0]->status == 'OVERPAID')) {
            BasicService::preparePaymentUpgradation($deposit);

            $data['status'] = 'success';
            $data['msg'] = 'Transaction was successful.';
            $data['redirect'] = route('success');
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'Invalid response.';
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
