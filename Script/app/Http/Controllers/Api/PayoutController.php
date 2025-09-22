<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\PayoutMethod;
use Carbon\Carbon;
use Facades\App\Services\BasicService;
use Facades\App\Http\Controllers\User\PayoutController as UserPayoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Http\Controllers\User;

class PayoutController extends Controller
{
    use ApiValidation, Upload, Notify;

    public function payout()
    {
        try {
            $data['gateways'] = PayoutMethod::where('is_active', 1)->get()->map(function ($query) {
                $query->logo = getFile($query->driver, $query->logo);
                return $query;
            });

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function payoutGetBankList(Request $request)
    {
        try {
            $currencyCode = $request->currencyCode;
            $methodObj = 'App\\Services\\Payout\\paystack\\Card';
            $data = $methodObj::getBank($currencyCode);
            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function payoutGetBankFrom(Request $request)
    {
        try {
            $bankName = $request->bankName;
            $bankArr = config('banks.' . $bankName);
            $value['bank'] = null;
            if ($bankArr['api'] != null) {

                $methodObj = 'App\\Services\\Payout\\flutterwave\\Card';
                $data = $methodObj::getBank($bankArr['api']);
                $value['bank'] = $data;
            }
            $value['input_form'] = $bankArr['input_form'];
            return response()->json($this->withSuccess($value));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function payoutPaystackSubmit(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'gateway' => 'required|integer',
                'currency' => 'required',
                'amount' => ['required', 'numeric']
            ]);

        if ($validateUser->fails()) {
            return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
        }

        try {

            if (!config('withdrawaldays')[date('l')]) {
                return response()->json($this->withErrors('Withdraw processing is off today'));
            }

            $amount = $request->amount;
            $payoutMethod = PayoutMethod::findOrFail($request->gateway);
            $supportedCurrency = $request->currency;

            $checkAmountValidateData = UserPayoutController::checkAmountValidate($amount, $supportedCurrency, $payoutMethod->id);

            if (!$checkAmountValidateData['status']) {
                return response()->json($this->withErrors($checkAmountValidateData['message']));
            }
            $user = Auth::user();

            if ($user->balance < $checkAmountValidateData['net_amount_in_base_currency']) {
                return response()->json($this->withErrors('Insufficient Balance'));
            }

            if (empty($request->bank)) {
                return response()->json($this->withErrors('Bank field is required'));
            }

            $payout = new Payout();
            $payout->user_id = $user->id;
            $payout->payout_method_id = $checkAmountValidateData['payout_method_id'];
            $payout->payout_currency_code = $checkAmountValidateData['currency'];
            $payout->amount = $checkAmountValidateData['amount'];
            $payout->charge = $checkAmountValidateData['payout_charge'];
            $payout->net_amount = $checkAmountValidateData['net_payout_amount'];
            $payout->amount_in_base_currency = $checkAmountValidateData['amount_in_base_currency'];
            $payout->charge_in_base_currency = $checkAmountValidateData['charge_in_base_currency'];
            $payout->net_amount_in_base_currency = $checkAmountValidateData['net_amount_in_base_currency'];
            $payout->information = null;
            $payout->feedback = null;
            $payout->status = 0;
            $payout->save();

            $rules = [];
            if ($payoutMethod->inputForm != null) {
                foreach ($payoutMethod->inputForm as $key => $cus) {
                    $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
                    if ($cus->type === 'file') {
                        $rules[$key][] = 'image';
                        $rules[$key][] = 'mimes:jpeg,jpg,png';
                        $rules[$key][] = 'max:10240';
                    } elseif ($cus->type === 'text') {
                        $rules[$key][] = 'max:191';
                    } elseif ($cus->type === 'number') {
                        $rules[$key][] = 'integer';
                    } elseif ($cus->type === 'textarea') {
                        $rules[$key][] = 'min:3';
                        $rules[$key][] = 'max:300';
                    }
                }
            }

            $validate = Validator::make($request->all(), $rules);
            if ($validate->fails()) {
                return response()->json($this->withErrors(collect($validate->errors())->collapse()));
            }

            $params = $payoutMethod->inputForm;
            $reqField = [];
            foreach ($request->except('_token', '_method', 'type', 'currency_code', 'bank') as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k == $inVal->field_name) {
                        if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                            try {
                                $file = $this->fileUpload($request[$inKey], config('filelocation.payoutLog.path'));
                                $reqField[$inKey] = [
                                    'field_name' => $inVal->field_name,
                                    'field_value' => $file['path'],
                                    'field_driver' => $file['driver'],
                                    'validation' => $inVal->validation,
                                    'type' => $inVal->type,
                                ];
                            } catch (\Exception $exp) {
                                session()->flash('error', 'Could not upload your ' . $inKey);
                                return back()->withInput();
                            }
                        } else {
                            $reqField[$inKey] = [
                                'field_name' => $inVal->field_name,
                                'validation' => $inVal->validation,
                                'field_value' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }

            $reqField['type'] = [
                'field_name' => "type",
                'field_value' => $request->type,
                'type' => 'text',
            ];
            $reqField['bank_code'] = [
                'field_name' => "bank_id",
                'field_value' => $request->bank,
                'type' => 'number',
            ];

            $payout->information = $reqField;
            $payout->status = 1;
            $payout->save();

            updateBalance($payout->user_id, $payout->net_amount_in_base_currency, 0);
            BasicService::makeTransaction($payout->user_id, $payout->net_amount_in_base_currency, '-', $payout->trx_id, 'Amount debited for payout', $payout->id, Payout::class, $payout->charge_in_base_currency);

            return response()->json($this->withSuccess('Withdraw request Successfully Submitted. Wait For Confirmation.'));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }


    public function payoutFlutterwaveSubmit(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'gateway' => 'required|integer',
                'currency' => 'required',
                'amount' => ['required', 'numeric']
            ]);

        if ($validateUser->fails()) {
            return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
        }

        try {

            if (!config('withdrawaldays')[date('l')]) {
                return response()->json($this->withErrors('Withdraw processing is off today'));
            }

            $amount = $request->amount;
            $payoutMethod = PayoutMethod::findOrFail($request->gateway);
            $supportedCurrency = $request->currency;

            $checkAmountValidateData = UserPayoutController::checkAmountValidate($amount, $supportedCurrency, $payoutMethod->id);

            if (!$checkAmountValidateData['status']) {
                return response()->json($this->withErrors($checkAmountValidateData['message']));
            }
            $user = Auth::user();

            if ($user->balance < $checkAmountValidateData['net_amount_in_base_currency']) {
                return response()->json($this->withErrors('Insufficient Balance'));
            }

            $purifiedData = $request->all();
            if (empty($purifiedData['transfer_name'])) {
                return response()->json($this->withErrors('Transfer field is required'));
            }

            $validation = config('banks.' . $purifiedData['transfer_name'] . '.validation');

            $rules = [];
            if ($validation != null) {
                foreach ($validation as $key => $cus) {
                    $rules[$key] = 'required';
                }
            }

            if ($request->transfer_name == 'NGN BANK' || $request->transfer_name == 'NGN DOM' || $request->transfer_name == 'GHS BANK'
                || $request->transfer_name == 'KES BANK' || $request->transfer_name == 'ZAR BANK' || $request->transfer_name == 'ZAR BANK') {
                $rules['bank'] = 'required';
            }


            $validate = Validator::make($request->all(), $rules);
            if ($validate->fails()) {
                return response()->json($this->withErrors(collect($validate->errors())->collapse()));
            }

            $payout = new Payout();
            $payout->user_id = $user->id;
            $payout->payout_method_id = $checkAmountValidateData['payout_method_id'];
            $payout->payout_currency_code = $checkAmountValidateData['currency'];
            $payout->amount = $checkAmountValidateData['amount'];
            $payout->charge = $checkAmountValidateData['payout_charge'];
            $payout->net_amount = $checkAmountValidateData['net_payout_amount'];
            $payout->amount_in_base_currency = $checkAmountValidateData['amount_in_base_currency'];
            $payout->charge_in_base_currency = $checkAmountValidateData['charge_in_base_currency'];
            $payout->net_amount_in_base_currency = $checkAmountValidateData['net_amount_in_base_currency'];
            $payout->information = null;
            $payout->feedback = null;
            $payout->status = 0;
            $payout->save();

            $collection = collect($purifiedData);
            $reqField = [];
            $metaField = [];

            if (config('banks.' . $purifiedData['transfer_name'] . '.input_form') != null) {
                foreach ($collection as $k => $v) {
                    foreach (config('banks.' . $purifiedData['transfer_name'] . '.input_form') as $inKey => $inVal) {
                        if ($k != $inKey) {
                            continue;
                        } else {
                            if ($inVal == 'meta') {
                                $metaField[$inKey] = [
                                    'field_name' => $k,
                                    'field_value' => $v,
                                    'type' => 'text',
                                ];
                            } else {
                                $reqField[$inKey] = [
                                    'field_name' => $k,
                                    'field_value' => $v,
                                    'type' => 'text',
                                ];
                            }
                        }
                    }
                }


                if ($request->transfer_name == 'NGN BANK' || $request->transfer_name == 'NGN DOM' || $request->transfer_name == 'GHS BANK'
                    || $request->transfer_name == 'KES BANK' || $request->transfer_name == 'ZAR BANK' || $request->transfer_name == 'ZAR BANK') {

                    $reqField['account_bank'] = [
                        'field_name' => 'Account Bank',
                        'field_value' => $request->bank,
                        'type' => 'text',
                    ];
                } elseif ($request->transfer_name == 'XAF/XOF MOMO') {
                    $reqField['account_bank'] = [
                        'field_name' => 'MTN',
                        'field_value' => 'MTN',
                        'type' => 'text',
                    ];
                } elseif ($request->transfer_name == 'FRANCOPGONE' || $request->transfer_name == 'mPesa' || $request->transfer_name == 'Rwanda Momo'
                    || $request->transfer_name == 'Uganda Momo' || $request->transfer_name == 'Zambia Momo') {
                    $reqField['account_bank'] = [
                        'field_name' => 'MPS',
                        'field_value' => 'MPS',
                        'type' => 'text',
                    ];
                }

                if ($request->transfer_name == 'Barter') {
                    $reqField['account_bank'] = [
                        'field_name' => 'barter',
                        'field_value' => 'barter',
                        'type' => 'text',
                    ];
                } elseif ($request->transfer_name == 'flutterwave') {
                    $reqField['account_bank'] = [
                        'field_name' => 'barter',
                        'field_value' => 'barter',
                        'type' => 'text',
                    ];
                }

                $payoutCurrencies = $payoutMethod->payout_currencies;
                $currencyInfo = collect($payoutCurrencies)->where('name', $request->currency)->first();

                $reqField['amount'] = [
                    'field_name' => 'amount',
                    'field_value' => $payout->amount * $currencyInfo->conversion_rate,
                    'type' => 'text',
                ];

                $payout->information = $reqField;
                $payout->meta_field = $metaField;


            } else {
                $payout->information = null;
                $payout->meta_field = null;
            }

            $payout->status = 1;
            $payout->payout_currency_code = $request->currency;
            $payout->save();

            updateBalance($payout->user_id, $payout->net_amount_in_base_currency, 0);
            BasicService::makeTransaction($payout->user_id, $payout->net_amount_in_base_currency, $payout->charge_in_base_currency, '-', $payout->trx_id, 'Amount debited for payout', $payout->id, Payout::class);

            return response()->json($this->withSuccess('Withdraw request Successfully Submitted. Wait For Confirmation.'));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function payoutSubmit(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'gateway' => 'required|integer',
                'currency_code' => 'required',
                'amount' => ['required', 'numeric']
            ]);

        if ($validateUser->fails()) {
            return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
        }

        try {

            if (!config('withdrawaldays')[date('l')]) {
                return response()->json($this->withErrors('Withdraw processing is off today'));
            }

            $amount = $request->amount;
            $payoutMethod = PayoutMethod::findOrFail($request->gateway);
            $supportedCurrency = $request->currency_code;

            $checkAmountValidateData = UserPayoutController::checkAmountValidate($amount, $supportedCurrency, $payoutMethod->id);

            if (!$checkAmountValidateData['status']) {
                return response()->json($this->withErrors($checkAmountValidateData['message']));
            }
            $user = Auth::user();

            if ($user->balance < $checkAmountValidateData['net_amount_in_base_currency']) {
                return response()->json($this->withErrors('Insufficient Balance'));
            }


            $params = $payoutMethod->inputForm;
            $rules = [];
            if ($params !== null) {
                foreach ($params as $key => $cus) {
                    $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
                    if ($cus->type === 'file') {
                        $rules[$key][] = 'image';
                        $rules[$key][] = 'mimes:jpeg,jpg,png';
                        $rules[$key][] = 'max:4048';
                    } elseif ($cus->type === 'text') {
                        $rules[$key][] = 'max:191';
                    } elseif ($cus->type === 'number') {
                        $rules[$key][] = 'integer';
                    } elseif ($cus->type === 'textarea') {
                        $rules[$key][] = 'min:3';
                        $rules[$key][] = 'max:300';
                    }
                }
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($this->withErrors(collect($validator->errors())->collapse()));
            }

            $payout = new Payout();
            $payout->user_id = $user->id;
            $payout->payout_method_id = $checkAmountValidateData['payout_method_id'];
            $payout->payout_currency_code = $checkAmountValidateData['currency'];
            $payout->amount = $checkAmountValidateData['amount'];
            $payout->charge = $checkAmountValidateData['payout_charge'];
            $payout->net_amount = $checkAmountValidateData['net_payout_amount'];
            $payout->amount_in_base_currency = $checkAmountValidateData['amount_in_base_currency'];
            $payout->charge_in_base_currency = $checkAmountValidateData['charge_in_base_currency'];
            $payout->net_amount_in_base_currency = $checkAmountValidateData['net_amount_in_base_currency'];
            $payout->information = null;
            $payout->feedback = null;
            $payout->status = 0;
            $payout->save();

            $reqField = [];
            foreach ($request->except('_token', '_method', 'type', 'currency_code', 'bank') as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k == $inVal->field_name) {
                        if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                            try {
                                $file = $this->fileUpload($request[$inKey], config('filelocation.payoutLog.path'), null, null, 'webp', 60);
                                $reqField[$inKey] = [
                                    'field_name' => $inVal->field_name,
                                    'field_value' => $file['path'],
                                    'field_driver' => $file['driver'],
                                    'validation' => $inVal->validation,
                                    'type' => $inVal->type,
                                ];
                            } catch (\Exception $exp) {
                                return response()->json($this->withErrors('Could not upload your ' . $inKey));
                            }
                        } else {
                            $reqField[$inKey] = [
                                'field_name' => $inVal->field_name,
                                'validation' => $inVal->validation,
                                'field_value' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }

            $payoutCurrencies = $payoutMethod->payout_currencies;
            if ($payoutMethod->is_automatic == 1) {
                $currencyInfo = collect($payoutCurrencies)->where('name', $request->currency_code)->first();
            } else {
                $currencyInfo = collect($payoutCurrencies)->where('currency_symbol', $request->currency_code)->first();
            }
            $reqField['amount'] = [
                'field_name' => 'amount',
                'field_value' => currencyPosition($payout->amount / $currencyInfo->conversion_rate),
                'type' => 'text',
            ];


            if ($payoutMethod->code == 'paypal') {
                $reqField['recipient_type'] = [
                    'field_name' => 'receiver',
                    'validation' => $inVal->validation,
                    'field_value' => $request->recipient_type,
                    'type' => 'text',
                ];
            }
            $payout->information = $reqField;
            $payout->status = 1;

            $user = Auth::user();

            updateBalance($payout->user_id, $payout->net_amount_in_base_currency, 0); //update user balance
            BasicService::makeTransaction($payout->user_id, $payout->net_amount_in_base_currency, '-', $payout->trx_id, 'Amount debited for payout', $payout->id, Payout::class, $payout->charge_in_base_currency);

            $this->userNotify($user, $payout); // send user notification

            $payout->save();

            return response()->json($this->withSuccess('Withdraw request Successfully Submitted. Wait For Confirmation.'));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function userNotify($user, $payout): void
    {
        $params = [
            'sender' => $user->name,
            'amount' => $payout->amount ,
            'currency' => $payout->payout_currency_code ,
            'transaction' => $payout->trx_id,
        ];

        $action = [
            "link" => route('admin.payout.log'),
            "icon" => "fa fa-money-bill-alt text-white",
            "name" => optional($payout->user)->firstname . ' ' . optional($payout->user)->lastname,
            "image" => getFile(optional($payout->user)->image_driver, optional($payout->user)->image),
        ];
        $firebaseAction = route('admin.payout.log');
        $this->adminMail('PAYOUT_REQUEST_TO_ADMIN', $params);
        $this->adminPushNotification('PAYOUT_REQUEST_TO_ADMIN', $params, $action);
        $this->adminFirebasePushNotification('PAYOUT_REQUEST_TO_ADMIN', $params, $firebaseAction);

        $params = [
            'amount' => $payout->amount,
            'currency' => $payout->payout_currency_code,
            'transaction' => $payout->trx_id,
        ];
        $action = [
            "link" => "#",
            "icon" => "fa fa-money-bill-alt text-white"
        ];
        $firebaseAction = "#";
        $this->sendMailSms($user, 'PAYOUT_REQUEST_FROM', $params);
        $this->userPushNotification($user, 'PAYOUT_REQUEST_FROM', $params, $action);
        $this->userFirebasePushNotification($user, 'PAYOUT_REQUEST_FROM', $params, $firebaseAction);
    }
}
