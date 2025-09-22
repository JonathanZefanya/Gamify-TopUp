<?php

namespace App\Traits;


use Facades\App\Services\BasicCurl;

trait CurrencyRateUpdate
{
    public function fiatRateUpdate($source, $currencies)
    {
        if (basicControl()->currency_layer_access_key) {
            $endpoint = 'live';
            $currency_layer_url = "http://api.currencylayer.com";
            $currency_layer_access_key = basicControl()->currency_layer_access_key;

            $baseCurrencyAPIUrl = "$currency_layer_url/$endpoint?access_key=$currency_layer_access_key&source=$source&currencies=$currencies";
            $baseCurrencyConvert = BasicCurl::curlGetRequest($baseCurrencyAPIUrl);
            $result = json_decode($baseCurrencyConvert);

            if (isset($result->success) && isset($result->quotes)) {
                return [
                    'status' => true,
                    'res' => $result->quotes,
                ];
            }

            return [
                'status' => false,
                'res' => 'something went wrong',
            ];
        }
        return [
            'status' => false,
            'res' => 'Please set currencylayer api key',
        ];
    }
}
