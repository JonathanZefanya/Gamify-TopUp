<?php

namespace App\Traits;

use App\Models\Gateway;
use Mockery\Exception;

trait PaymentValidationCheck
{
    public function validationCheck($amount, $gateway, $currency, $cryptoCurrency = null, $isBase = 'no')
    {
        try {
            $selectGateway = Gateway::where('id', $gateway)->where('status', 1)->first();
            if (!$selectGateway) {
                return ['status' => false, 'message' => "Payment method not available for this transaction"];
            }

            $selectedCurrency = array_search($currency, $selectGateway->supported_currency);
            if ($selectedCurrency !== false) {
                $selectedPayCurrency = $selectGateway->supported_currency[$selectedCurrency];
            } else {
                return ['status' => false, 'message' => "Please choose the currency you'd like to use for payment"];
            }

            if ($selectGateway) {
                $receivableCurrencies = $selectGateway->receivable_currencies;
                if (is_array($receivableCurrencies)) {
                    if ($selectGateway->id < 999) {
                        $currencyInfo = collect($receivableCurrencies)->where('name', $selectedPayCurrency)->first();
                    } else {
                        $currencyInfo = collect($receivableCurrencies)->where('currency', $selectedPayCurrency)->first();
                    }
                } else {
                    return null;
                }
            }
            $currencyType = $selectGateway->currency_type;
            $limit = $currencyType == 0 ? 8 : 2;
            if ($isBase == 'yes') {
                $amount = getAmount($amount * $currencyInfo->conversion_rate, $limit);
            } else {
                $amount = getAmount($amount, $limit);
            }

            $payable_amount = $amount;
            $status = false;

            if ($currencyInfo) {
                $percentage = getAmount($currencyInfo->percentage_charge, $limit);
                $percentage_charge = getAmount(($payable_amount * $percentage) / 100, $limit);
                $fixed_charge = getAmount($currencyInfo->fixed_charge, $limit);

                $min_limit = getAmount($currencyInfo->min_limit, $limit);
                $max_limit = getAmount($currencyInfo->max_limit, $limit);
                $charge = getAmount($percentage_charge + $fixed_charge, $limit);
            }

            $basicControl = basicControl();
            $payable_amount_baseCurrency = getAmount($amount / $currencyInfo->conversion_rate, $limit);
            $charge_baseCurrency = getAmount($charge / $currencyInfo->conversion_rate, $limit);
            $payable_amount = getAmount($payable_amount + $charge, $limit);

            if ($payable_amount < $min_limit || $payable_amount > $max_limit) {
                if ($selectGateway->currency_type) {
                    $message = "Minimum payment $min_limit {$currencyInfo->currency_symbol} and maximum payment limit $max_limit {$currencyInfo->currency_symbol}";
                } else {
                    $message = "Minimum payment $min_limit USD and maximum payment limit $max_limit USD";
                }
            } elseif ($payable_amount < 0) {
                $message = "Unprocessable Amount";
            } else {
                $status = true;
                $message = "Amount : $payable_amount_baseCurrency" . " " . $basicControl->base_currency;
            }

            $data['status'] = $status;
            $data['message'] = $message;
            $data['gateway_id'] = $selectGateway->id;
            $data['gateway_name'] = $selectGateway->name;
            $data['fixed_charge'] = $fixed_charge;
            $data['percentage'] = $percentage;
            $data['percentage_charge'] = $percentage_charge;
            $data['min_limit'] = $min_limit;
            $data['max_limit'] = $max_limit;
            $data['payable_amount'] = $payable_amount;
            $data['charge'] = $charge;
            $data['amount'] = $amount;
            $data['conversion_rate'] = $currencyInfo->conversion_rate ?? 1;
            $data['payable_amount_baseCurrency'] = $payable_amount_baseCurrency;
            $data['charge_baseCurrency'] = $charge_baseCurrency;
            $data['currency'] = $selectGateway->currency_type ? ($currencyInfo->name ?? $currencyInfo->currency) : 'USD';
            $data['base_currency'] = $basicControl->base_currency;
            $data['currency_limit'] = $limit;
            $data['payment_crypto_currency'] = $selectGateway->currency_type ? null : ($currencyInfo->name ?? $currencyInfo->currency);

            return $data;

        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
