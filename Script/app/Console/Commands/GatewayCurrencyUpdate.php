<?php

namespace App\Console\Commands;

use App\Models\Gateway;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GatewayCurrencyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gateway-currency-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (basicControl()->currency_layer_auto_update == 1) {
            $gateways = Gateway::query();
            $paymentCurrencies = $gateways->pluck('currencies');

            $fiatCurrency = [];
            foreach ($paymentCurrencies as $key => $currency) {
                if (isset($currency->{'0'})) {
                    $currencyKeys = array_keys((array)$currency->{'0'});
                    $fiatCurrency = array_merge($fiatCurrency, $currencyKeys);
                }
            }

            $paymentCurrencies = $gateways->pluck('supported_currency')->flatMap(function ($currency) {
                return (array)$currency;
            })->unique()->toArray();

            $currencies = array_unique(array_intersect($fiatCurrency, $paymentCurrencies));

            $endpoint = 'live';
            $source = basicControl()->base_currency;
            $currency_layer_url = "http://api.currencylayer.com";
            $currency_layer_access_key = basicControl()->currency_layer_access_key;

            $currencyLists = array();
            foreach ($currencies as $currency) {
                $currencyLists[] = $currency;
            }

            $currencyLists = array_unique($currencyLists);
            $currencies = implode(',', $currencyLists);

            $CurrencyAPIUrl = "$currency_layer_url/$endpoint?access_key=$currency_layer_access_key&source=$source&currencies=$currencies";

            $response = Http::acceptJson()->get($CurrencyAPIUrl);

            $autoCurrencyUpdate = json_decode($response->body());

            $autoUp = [];
            foreach ($autoCurrencyUpdate->quotes as $key => $quote) {
                $strReplace = str_replace($autoCurrencyUpdate->source, '', $key);
                $autoUp[$strReplace] = $quote;
            }

            $usdToBase = 1.00;
            $currenciesArr = [];
            foreach ($gateways as $gateway) {
                foreach ($gateway->receivable_currencies as $key => $currency) {
                    foreach ($currency as $key1 => $item) {
                        $resRate = $this->getCheck($currency['name'], $autoUp);
                        $curRate = round($resRate / $usdToBase, 2);
                        if ($resRate && $key1 == 'conversion_rate') {
                            $currenciesArr[$key][$key1] = $curRate;
                        } else {
                            $currenciesArr[$key][$key1] = $item;
                        }
                    }
                }
                $gateways->receivable_currencies = $currenciesArr;
                $gateways->save();
            }
            return 0;
        }
    }

    public function getCheck($currency, $autoUp)
    {
        foreach ($autoUp as $key => $auto) {
            if ($key == $currency) {
                return $auto;
            }
        }
    }
}
