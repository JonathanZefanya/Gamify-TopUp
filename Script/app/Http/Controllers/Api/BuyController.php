<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Deposit;
use App\Traits\ApiPayment;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use App\Models\Gateway;
use App\Models\SellPost;
use App\Models\SellPostCategory;
use App\Models\SellPostOffer;
use App\Models\SellPostPayment;
use Facades\App\Services\BasicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class BuyController extends Controller
{
    use ApiValidation, Notify, ApiPayment;

    public function buyList(Request $request)
    {
        $data['my_id'] = auth()->id();
        $selectQuery = SellPost::get();

        $max = $selectQuery->max('price');
        $min = $selectQuery->min('price');


        $data['sellPost'] = SellPost::when(request('sortByCategory', false), function ($q, $sortByCategory) {
            $newArr = explode(',', $sortByCategory);
            $q->whereHas('category', function ($q) {
                $q->where('status', 1);
            })->whereIn('category_id', $newArr);

        })->when(request('search', false), function ($q, $search) {
            $q->where('title', 'LIKE', "%$search%");
        })
            ->where('status', 1)
            ->where('payment_status', '!=', 1)
            ->when(request('minPrice', false), function ($q, $minPrice) {
                $maxPrice = \request('maxPrice');
                $q->whereBetween('price', [$minPrice, $maxPrice]);
            })
            ->when(request('sortBy', false), function ($q, $sortBy) {
                if ($sortBy == 'desc') {
                    $q->orderBy('updated_at', 'desc');
                }
                if ($sortBy == 'asc') {
                    $q->orderBy('created_at', 'asc');
                }
                if ($sortBy == 'low_to_high') {
                    $q->orderBy('price', 'asc');
                }
                if ($sortBy == 'high_to_low') {
                    $q->orderBy('price', 'desc');
                }

            })
            ->paginate(basicControl()->paginate);

        $data['max'] = $max;
        $data['min'] = $min;


        $data['categories'] = SellPostCategory::with('details')->whereHas('activePost')->whereStatus(1)->get();
        return response()->json($this->withSuccess($data));
    }

    public function makeOffer(Request $request)
    {
        $purifiedData = $request->all();

        $rules = [
            'sell_post_id' => 'required|numeric',
            'amount' => 'required|numeric|min:1',
            'description' => 'required',
        ];
        $message = [
            'amount.required' => 'Amount field is required',
            'description.required' => 'Description field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $auth = auth()->user();
        $sellPost = SellPost::where('status', 1)->find($request->sell_post_id);
        if (!$sellPost) {
            return response()->json($this->withErrors('Sell Post data not found'));
        }

        if ($sellPost->payment_status == 1) {
            return response()->json($this->withErrors('You can not offer already someone purchases'));
        }

        $sellPostOffer = SellPostOffer::whereUser_id($auth->id)->whereSell_post_id($sellPost->id)->count();

        if ($sellPostOffer > 0) {
            $sellPostOffer = SellPostOffer::whereUser_id($auth->id)->whereSell_post_id($request->sell_post_id)->update(["amount" => $request->amount,
                "description" => $request->description,
                "status" => 3
            ]);

        } else {
            SellPostOffer::create([
                'author_id' => $sellPost->user_id,
                'user_id' => Auth::user()->id,
                'sell_post_id' => $request->sell_post_id,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
        }

        $user = $sellPost->user;
        if ($sellPostOffer > 0) {
            $this->isReOffer($sellPost, $user, $request);
        } else {
            $msg = [
                'link' => route('sellPost.details', [@slug($sellPost->title), $request->sell_post_id]),
                'title' => $sellPost->title,
                'amount' => $request->amount . ' ' . config('basic.currency'),
                'offer_by' => $sellPost->user->firstname . ' ' . $sellPost->user->lastname,
                'description' => $request->description
            ];
            $action = [
                "link" => route('sellPost.details', [@slug($sellPost->title), $request->sell_post_id]),
                "icon" => "fa fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($user, 'SELL_OFFER', $msg, $action);

            $this->sendMailSms($user, 'SELL_OFFER', $msg);
        }

        return response()->json($this->withSuccess('Offer Send'));
    }

    public function isReOffer($sellPost, $user, $request)
    {
        $msg = [
            'link' => route('sellPost.details', [@slug($sellPost->title), $request->sell_post_id]),
            'title' => $sellPost->title,
            'amount' => $request->amount . ' ' . config('basic.currency'),
            'offer_by' => $sellPost->user->firstname . ' ' . $sellPost->user->lastname,
            'description' => $request->description
        ];
        $action = [
            "link" => route('sellPost.details', [@slug($sellPost->title), $request->sell_post_id]),
            "icon" => "fa fa-money-bill-alt text-white"
        ];
        $this->userPushNotification($user, 'SELL_RE_OFFER', $msg, $action);

        $this->sendMailSms($user, 'SELL_RE_OFFER', $msg);

        return 0;
    }

    public function buyIdDetails(Request $request)
    {
        try {
            $id = $request->query('id');
            $sellPost = SellPost::where('id', $id)
                ->where('status', 1)
                ->first();
            $data['sellPostOffer'] = SellPostOffer::where('sell_post_id', $id)->orderBy('amount', 'desc')->take(3)->get();
            if ($data['sellPostOffer']->isEmpty()) {
                return response()->json($this->withErrors('Sell Post Offer data not found'));
            }
            $data['sellpostStatus'] = [];
            $sellpostPaymentStatus = null;
            if ($sellPost->payment_status == 1) {
                $sellpostPaymentStatus = 'Completed';
            }else {
                if ($sellPost->payment_lock == 1) {
                    if (Auth::check() && Auth::id() == $sellPost->lock_for){
                        $sellpostPaymentStatus = 'Waiting Payment';
                    }elseif (Auth::check() &&  Auth::id() == $sellPost->user_id){
                        $sellpostPaymentStatus = 'Payment Processing';
                    }else{
                        $sellpostPaymentStatus = 'Going to Sell';
                    }
                }
            }
            $data['sellpostStatus'] =[
                'sellpostPaymentStatus' => $sellpostPaymentStatus,
            ];

            $data['price'] = $sellPost->price;
            if (Auth::check()) {
                $user = Auth::user();
                $checkMyProposal = SellPostOffer::where([
                    'user_id' => $user->id,
                    'sell_post_id' => $sellPost->id,
                    'status' => 1,
                    'payment_status' => 0,
                ])->first();
                if ($checkMyProposal) {
                    $data['price'] = (int)$checkMyProposal->amount;
                }
            }
            $data['sellPost'] = $sellPost;

            $data['gateways'] = Gateway::whereStatus(1)->orderBy('sort_by')->get()->map(function ($query) {
                $query->image = getFile($query->driver, $query->image);
                return $query;
            });

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function buyIdMakePayment(Request $request)
    {
        $purifiedData = $request->all();

        $rules = [
            'sellPostId' => ['required', 'numeric'],
            'gateway' => ['nullable'],
            'selectedCurrency' => 'nullable',
        ];
        $message = [
            'gateway.required' => 'Please select a payment method',
            'sellPostId.required' => 'Please select a sell post'
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $sellPost = SellPost::where('id', $request->sellPostId)
            ->where('status', 1)
            ->first();

        if (!$sellPost) {
            return response()->json($this->withErrors('This post already sold or not available to sell'));
        }

        $price = $sellPost->price;
        if (Auth::check()) {
            $user = Auth::user();
            $checkMyProposal = SellPostOffer::where([
                'user_id' => $user->id,
                'sell_post_id' => $sellPost->id,
                'status' => 1,
                'payment_status' => 0,
            ])->first();
            if ($checkMyProposal) {
                $price = (int)$checkMyProposal->amount;
            }
        }

        $discount = 0;
        $user = auth()->user();

        $reqAmount = $price - $discount;

        if ($request->selectedCurrency) {
            $checkAmountValidate = $this->validationCheck($reqAmount, $request->gateway, $request->selectedCurrency, null, 'yes');

            if (!$checkAmountValidate['status']) {
                return response()->json($this->withErrors($checkAmountValidate['message']));
            }
        }

        if (!$request->gateway && $user->balance < $reqAmount) {
            return back()->with('error', 'Insufficient Wallet Balance')->withInput();
        }

        $admin_amount = $reqAmount * $sellPost->sell_charge / 100;
        $seller_amount = $reqAmount - $admin_amount;

        $sellPostPayment = new SellPostPayment();
        $sellPostPayment->user_id = $user->id;
        $sellPostPayment->sell_post_id = $sellPost->id;
        $sellPostPayment->price = $reqAmount;
        $sellPostPayment->seller_amount = $seller_amount;
        $sellPostPayment->admin_amount = $admin_amount;
        $sellPostPayment->discount = $discount;
        $sellPostPayment->transaction = strRandom();

        $sellPostPayment->save();

        if (!$request->gateway) {
            if ($user->balance > $reqAmount) {
                $user->balance -= $reqAmount;
                $user->save();
                $sellPostPayment->payment_status = 1;
                $sellPostPayment->save();

                $sellPost->payment_status = 1;
                $sellPost->lock_for = $user->id;
                $sellPost->save();

                $authorUser = $sellPost->user;

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

                $remark = 'Sell Post Payment Via Wallet';
                BasicService::makeTransaction($user->id, $reqAmount, 0, '-',
                    $sellPostPayment->transaction, $remark, $sellPostPayment->id, SellPostPayment::class);

                return response()->json($this->withSuccess('Your order has been processed'));
            } else {
                return response()->json($this->withSuccess('Insufficient Balance'));
            }
        } else {
            $deposit = Deposit::create([
                'user_id' => auth()->id(),
                'payment_method_id' => $checkAmountValidate['gateway_id'],
                'payment_method_currency' => $checkAmountValidate['currency'],
                'amount' => $checkAmountValidate['amount'],
                'percentage_charge' => $checkAmountValidate['percentage_charge'],
                'fixed_charge' => $checkAmountValidate['fixed_charge'],
                'payable_amount' => $checkAmountValidate['payable_amount'],
                'payable_amount_in_base_currency' => $checkAmountValidate['payable_amount_baseCurrency'],
                'charge_base_currency' => $checkAmountValidate['charge_baseCurrency'],
                'status' => 0,
                'depositable_id' => $sellPostPayment->id,
                'depositable_type' => SellPostPayment::class,
            ]);

            $val['trxId'] = $deposit->trx_id;
            return response()->json($this->withSuccess($val));
        }
    }
}
