<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateReviewAndRatingJob;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Models\TopUp;
use App\Models\TopUpService;
use App\Traits\MakeOrder;
use App\Traits\PaymentValidationCheck;
use App\Traits\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TopUpController extends Controller
{
    use MakeOrder, PaymentValidationCheck, Rating;

    protected $theme;

    public function __construct()
    {
        $this->theme = template();
    }

    public function topupList(Request $request)
    {
        $data['categories'] = Category::where('type', 'top_up')->where('status', 1)
            ->withCount(['topUps as active_children' => function ($q) {
                $q->where('status', 1)->whereHas('activeServices');
            }])
            ->orderBy('sort_by', 'ASC')
            ->get(['id', 'name', 'icon', 'type', 'status', 'sort_by']);
        list($min, $max) = array_pad(explode(';', $request->my_range, 2), 2, 0);

        $valueRange = TopUpService::selectRaw('MAX(price) as highValue, MIN(price) as lowValue')->first();
        $data['max'] = $request->has('my_range') ? $max : $valueRange->highValue;
        $data['min'] = $request->has('my_range') ? $min : $valueRange->lowValue;
        $data['max_price'] = $valueRange->highValue ?? 1000;
        $data['min_price'] = $valueRange->lowValue ?? 0;


        $data['topUp'] = TopUp::where('status', 1)
            ->when(isset($request->search) && !empty($request->search), function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->search}%");
            })
            ->when(isset($request->category) && !empty($request->category), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when(isset($request->filter) && !empty($request->filter), function ($query) use ($request) {
                if ($request->filter == 'all') {
                    $query->orderBy('sort_by', 'desc');
                } elseif ($request->filter == '1') {
                    $query->orderBy('avg_rating', 'desc');
                } elseif ($request->filter == '2') {
                    $query->latest();
                } elseif ($request->filter == '3') {
                    $query->orderBy('created_at', 'asc');
                }
            })
            ->orderBy('sort_by', 'ASC')
            ->paginate(12);

        return view(template() . 'frontend.topUp.list', $data);
    }

    public function getDirectTopUp(Request $request)
    {
        $offset = request()->get('offset', 0);
        $limit = request()->get('limit', 16);

        if (!$request->catId) {
            $data['categories'] = Category::type('top_up')
                ->active()
                ->sort()
                ->withCount(['topUps as active_children' => function ($q) {
                    $q->where('status', 1)->whereHas('activeServices');
                }])
                ->get(['id', 'name', 'icon', 'type', 'status', 'sort_by']);
        }

        $data['topUps'] = TopUp::select(['id', 'category_id', 'status', 'name', 'slug', 'image'])
            ->where('status', 1)
            ->when($request->catId, function ($query) use ($request) {
                return $query->where('category_id', $request->catId);
            })
            ->whereHas('activeServices')
            ->skip($offset)
            ->take($limit)
            ->get();

        return response()->json($data, 200);
    }


    public function directTopUpDetails($slug = null)
    {
        $data['topUp'] = TopUp::with(['activeServices'])->where(['status' => 1, 'slug' => $slug])->firstOrFail();
        $data['reviewStatic'] = $this->getTopReview(TopUp::class, $data['topUp']->id);
        return view(template() . 'frontend.topUp.details', $data);
    }

    public function buy(Request $request)
    {

        $this->validate($request, [
            'topUpId' => ['required', 'numeric'],
            'serviceId' => ['required', 'numeric']
        ], [
            'topUpId.required' => 'Unprocessable. Please try again later',
            'serviceId.required' => 'Unprocessable. Please try again later'
        ]);

        DB::beginTransaction();
        try {
            $service = TopUpService::whereHas('topUp', function ($query) {
                $query->where('status', 1);
            })->where('status', 1)->findOrFail($request->serviceId);
            $topUp = $service->topUp;

            $rules = [];
            if ($topUp->order_information != null) {
                foreach ($topUp->order_information as $cus) {
                    $rules[$cus->field_name] = ['required'];
                    if ($cus->field_type == 'select') {
                        $options = implode(',', array_keys((array)$cus->option));
                        array_push($rules[$cus->field_name], 'in:' . $options);
                    }
                }
            }

            $this->validate($request, $rules);

            $info = [];

            if ($topUp->order_information != null) {
                foreach ($topUp->order_information as $cus) {
                    if (isset($request->{$cus->field_name})) {
                        $info[$cus->field_name] = [
                            'field' => $cus->field_value,
                            'value' => $request->{$cus->field_name},
                        ];
                    }
                }
            }

            $order = $this->orderCreate(showActualPrice($service), 'topup', $info);
            $this->orderDetailsCreate($order, $service, TopUpService::class);

            session()->forget(['topupPrice']);
            session()->put('topupPrice', $order->amount);

            DB::commit();
            return redirect()->route('topUp.user.order', ['utr' => $order->utr]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function order(Request $request)
    {
        $order = Order::select(['id', 'user_id', 'amount', 'payment_status',
            'status', 'order_for', 'utr', 'created_at', 'discount'])
            ->where(['utr' => $request->utr, 'payment_status' => 0, 'status' => 0, 'order_for' => 'topup'])->firstOrFail();

        if ($request->method() == 'GET') {
            $gateways = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
            return view(template() . 'frontend.topUp.order', compact('order', 'gateways'));
        } elseif ($request->method() == 'POST') {

            try {
                if ($order->amount > 0) {
                    if (isset($request->gateway_id) && $request->gateway_id == '-1') {
                        $payByWallet = $this->payByWallet($order);
                        if (!$payByWallet['status']) {
                            return back()->with('error', $payByWallet['message']);
                        }

                        return redirect()->route('user.topUpOrder', ['type' => 'wait-sending'])
                            ->with('success', 'Order has been placed successfully');
                    }
                    $validationRules = [
                        'gateway_id' => 'required|integer|min:1',
                        'supported_currency' => 'required',
                    ];

                    $validate = Validator::make($request->all(), $validationRules);
                    if ($validate->fails()) {
                        return back()->withErrors($validate)->withInput();
                    }
                    $gateway = Gateway::select(['id', 'status'])->where('status', 1)->findOrFail($request->gateway_id);
                    $checkAmountValidate = $this->validationCheck($order->amount, $gateway->id, $request->supported_currency, null, 'yes');
                    if (!$checkAmountValidate['status']) {
                        return back()->with('error', $checkAmountValidate['message']);
                    }

                    $deposit = $this->depositCreate($checkAmountValidate, Order::class, $order->id);
                    return redirect(route('payment.process', $deposit->trx_id));
                } else {
                    return back()->with('error', 'Unable to processed order');
                }
            } catch (\Exception $exception) {
                return back()->with('error', 'Something went wrong. Please try later');
            }
        }
    }

    public function addReview(Request $request)
    {
        $this->validate($request, [
            'topUpId' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:200',
        ]);

        try {
            $topUpId = $request->topUpId;
            $topUp = TopUp::select(['id', 'status', 'name'])->where('status', 1)->findOrFail($topUpId);

            $isHasOrder = OrderDetail::with(["detailable" => function ($query) use ($topUpId) {
                $query->whereHas('topUp', function ($q) use ($topUpId) {
                    $q->where('id', $topUpId);
                });
            }])
                ->whereHas('order', function ($qq) {
                    $qq->where('payment_status', 1);
                })
                ->where('user_id', auth()->id())
                ->where('detailable_type', TopUpService::class)
                ->exists();

            if ($isHasOrder) {

                $review = Review::updateOrCreate([
                    'reviewable_type' => TopUp::class,
                    'reviewable_id' => $topUpId,
                    'user_id' => auth()->id(),
                ], [
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ]);

                UpdateReviewAndRatingJob::dispatch($review->id, TopUp::class, $topUpId);

                $this->reviewNotifyToAdmin(auth()->user(), $topUp->name, $request->rating);
                return back()->with('success', 'Review Added Successfully');
            }
            return back()->with('error', 'You are not eligible for review');
        } catch (\Exception $e) {
            return back()->with('error', 'You are not eligible for review');
        }
    }

    public function couponApply(Request $request)
    {
        $order = Order::own()->with(['orderDetails:id,order_id,parent_id'])->where('payment_status', 0)
            ->where('utr', $request->utr)->latest()->first();

        if ($order->coupon_code == $request->couponCode) {
            return response()->json([
                'status' => 'error',
                'message' => 'Already Applied',
            ]);
        }

        if ($order) {
            $coupon = Coupon::where('code', $request->couponCode)->where('status', 1)
                ->where('start_date', '<=', Carbon::now())->first();

            if ($coupon && (!$coupon->end_date || $coupon->end_date > Carbon::now())) {

                $parentIds = $order->orderDetails->pluck('parent_id')->toArray();
                if ($order->order_for == 'topup') {
                    if (empty(array_diff($coupon->top_up_list ?? [], $parentIds))) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'You are not eligible to apply this coupon',
                        ]);
                    }
                }

                if ($order->order_for == 'card') {
                    if (empty(array_diff($coupon->card_list ?? [], $parentIds))) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'You are not eligible to apply this coupon',
                        ]);
                    }
                }

                if ($coupon->is_unlimited || ($coupon->used_limit > $coupon->total_use)) {
                    $discount = $coupon->discount;
                    if ($coupon->discount_type == 'percent') {
                        $discount = ($order->amount * $coupon->discount) / 100;
                    }

                    $order->coupon_id = $coupon->id;
                    $order->coupon_code = $coupon->code;
                    $order->amount = (($order->amount + $order->discount) - $discount);
                    $order->discount = $discount;
                    $order->save();

                    return response()->json([
                        'status' => 'success',
                        'discount' => getAmount($discount,2),
                        'amount' => getAmount($order->amount,2),
                        'total_amount' => userCurrencyPosition($order->amount),
                        'message' => "You get " . userCurrencyPosition($discount) . " discount",
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'You are not eligible to apply this coupon',
        ]);
    }

}
