<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Fund;
use App\Models\Gateway;
use App\Traits\MakeOrder;
use Illuminate\Http\Request;
use App\Traits\PaymentValidationCheck;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{

    use PaymentValidationCheck, MakeOrder;

    public function supportedCurrency(Request $request)
    {
        $gateway = Gateway::where('id', $request->gateway)->first();
        return response([
            'success' => true,
            'data' => $gateway->supported_currency,
            'currencyType' => $gateway->currency_type,
        ]);
    }

    public function checkAmount(Request $request)
    {
        if ($request->ajax()) {
            $amount = $request->amount;
            $selectedCurrency = $request->selected_currency;

            $selectGateway = $request->select_gateway;
            $selectedCryptoCurrency = $request->selectedCryptoCurrency;
            $amountType = $request->amountType ?? 'base';
            $data = $this->checkAmountValidate($amount, $selectedCurrency, $selectGateway, $selectedCryptoCurrency, $amountType);

            return response()->json($data);
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function checkAmountValidate($amount, $selectedCurrency, $selectGateway, $selectedCryptoCurrency = null, $amountType = 'base')
    {
        return $this->validationCheck($amount, $selectGateway, $selectedCurrency, $selectedCryptoCurrency, $amountType);
    }


    public function paymentRequest(Request $request)
    {
        try {
            $checkAmountValidate = $this->validationCheck($request->amount, $request->gateway_id,
                $request->supported_currency, $request->supported_crypto_currency, 'other');

            if (!$checkAmountValidate['status']) {
                return back()->with('error', $checkAmountValidate['message']);
            }

            $deposit = $this->depositCreate($checkAmountValidate);
            return redirect(route('payment.process', $deposit->trx_id));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
