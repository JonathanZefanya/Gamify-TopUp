<?php

namespace App\Traits;

use App\Http\Controllers\PaymentController;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GiftCardSell;
use App\Models\SellPostOffer;
use App\Models\SellPostPayment;
use App\Models\TopUpSell;
use App\Models\VoucherSell;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Facades\App\Services\BasicService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

trait ApiPayment
{
    use ApiValidation, Notify, PaymentValidationCheck;


    public function proposalCheck($user, $sellPost): void
    {
        $sellPost->payment_status = 1;
        $sellPost->lock_for = $user->id;
        $sellPost->save();

        $checkMyProposal = SellPostOffer::where([
            'user_id' => $user->id,
            'sell_post_id' => $sellPost->id,
            'status' => 1,
            'payment_status' => 0,
        ])->first();
        if ($checkMyProposal) {
            $checkMyProposal->payment_status = 1;
            $checkMyProposal->save();
        }

        SellPostOffer::where('user_id', '!=', $user->id)->where('sell_post_id', $sellPost->id)->get()->map(function ($item) {
            $item->uuid = null;
            $item->save();
        });
    }

    public function codeSend($object, $type = 'voucher'): void
    {
        $lackingCode = 0;
        $qty = $object->qty;
        if ($type == 'voucher') {
            $vCodes = $object->service->voucherActiveCodes->take($qty);
        } else {
            $vCodes = $object->service->giftCardActiveCodes->take($qty);
        }
        if ($qty > count($vCodes)) {
            $lackingCode = $qty - count($vCodes);
        }
        $orderCode = [];
        $i = 0;

        foreach ($vCodes as $vCode) {
            if ($i < $qty) {
                array_push($orderCode, $vCode->code);
                $vCode->status = 2;
                $vCode->save();
            }
            $i++;
        }

        $object->stock_short = $lackingCode;
        $object->code = $orderCode;
        $object->status = 1;
        $object->save();
    }

    public function paymentDone(Request $request)
    {
        $rules = [
            'id' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $deposit = Deposit::latest()->where('id', $request->id)->orWhere('trx_id', $request->id)->where('status', 0)->first();
        if (!$deposit) {
            return response()->json($this->withErrors('Record not found'));
        }

        BasicService::preparePaymentUpgradation($deposit);
        return response()->json($this->withSuccess('Payment has been completed'));
    }

    public function cardPayment(Request $request)
    {
        $rules = [
            'id' => 'required',
            'card_number' => 'required',
            'card_name' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            'card_cvc' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $deposit = Deposit::latest()->where('trx_id', $request->id)->orWhere('id', $request->id)->where('status', 0)->first();
        if (!$deposit) {
            return response()->json($this->withErrors('Record not found'));
        }

        $getwayObj = 'App\\Services\\Gateway\\' . $deposit->gateway->code . '\\Payment';
        if (!method_exists($getwayObj, 'mobileIpn')) {
            return response()->json($this->withErrors("Method mobileIpn does not exist in $getwayObj"));
        }

        $data = $getwayObj::mobileIpn($request, $deposit->gateway, $deposit);

        if ($data == 'success') {
            return response()->json($this->withSuccess('Payment has been complete'));
        } else {
            return response()->json($this->withErrors('unsuccessful transaction.'));
        }
    }

    public function showOtherPayment(Request $request)
    {
        $rules = [
            'id' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $deposit = Deposit::latest()->where('trx_id', $request->id)->orWhere('id', $request->id)->where('status', 0)->first();
        if (!$deposit) {
            return response()->json($this->withErrors('Record not found'));
        }

        $val['url'] = route('paymentView', $deposit->id);
        return response()->json($this->withSuccess($val));
    }

    public function paymentView($depositId)
    {
        $deposit = Deposit::latest()->find($depositId);
        try {
            if ($deposit) {
                $getwayObj = 'App\\Services\\Gateway\\' . $deposit->gateway->code . '\\Payment';
                $data = $getwayObj::prepareData($deposit, $deposit->gateway);
                $data = json_decode($data);

                if (isset($data->error)) {
                    $result['status'] = false;
                    $result['message'] = $data->message;
                    return response($result, 200);
                }

                if (isset($data->redirect)) {
                    return redirect($data->redirect_url);
                }

                if ($data->view) {
                    $parts = explode(".", $data->view);
                    $desiredValue = end($parts);
                    $newView = 'mobile-payment.' . $desiredValue;
                    return view($newView, compact('data', 'deposit'));
                }

                abort(404);
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function manualPaymentSubmit(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->withErrors(collect($validator->messages())->collapse());
        }

        $deposit = Deposit::latest()->where('trx_id', $request->id)->orWhere('id', $request->id)->where('status', 0)->first();
        if (!$deposit) {
            return response()->json($this->withErrors('Record not found'));
        }

        try {
            $params = optional($deposit->gateway)->parameters;
            $reqData = $request->except('_token', '_method');
            $rules = [];
            if ($params !== null) {
                foreach ($params as $key => $cus) {
                    $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
                    if ($cus->type === 'file') {
                        $rules[$key][] = 'image';
                        $rules[$key][] = 'mimes:jpeg,jpg,png';
                        $rules[$key][] = 'max:100240';
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

            $validator = Validator::make($reqData, $rules);
            if ($validator->fails()) {
                return response()->json($this->withErrors(collect($validator->errors())->collapse()));
            }

            $reqField = [];
            if ($params != null) {
                foreach ($request->except('_token', '_method', 'type') as $k => $v) {
                    foreach ($params as $inKey => $inVal) {
                        if ($k == $inKey) {
                            if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                                try {
                                    $file = $this->fileUpload($request[$inKey], config('filelocation.deposit.path'), config('filesystems.default'), null, 'webp', 80, null, 40);
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
            }
            $deposit->update([
                'information' => $reqField,
                'created_at' => Carbon::now(),
                'status' => 2,
            ]);

            $msg = [
                'username' => optional($deposit->user)->username,
                'amount' => currencyPosition($deposit->payable_amount_in_base_currency),
                'gateway' => optional($deposit->gateway)->name
            ];
            $action = [
                "name" => optional($deposit->user)->firstname . ' ' . optional($deposit->user)->lastname,
                "image" => getFile(optional($deposit->user)->image_driver, optional($deposit->user)->image),
                "link" => route('admin.user.payment', $deposit->user_id),
                "icon" => "fa fa-money-bill-alt text-white"
            ];

            $this->adminPushNotification('PAYMENT_REQUEST', $msg, $action);
            $this->adminFirebasePushNotification('PAYMENT_REQUEST', $msg, $action);
            $this->adminMail('PAYMENT_REQUEST', $msg);

            return response()->json($this->withSuccess('You request has been taken.'));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }
}
