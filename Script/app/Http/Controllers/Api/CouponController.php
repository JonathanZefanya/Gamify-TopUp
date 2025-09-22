<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    use ApiValidation, Notify;

    public function coupons(){

        $data['coupons']  = Coupon::where(function ($query) {
            $query->whereNull('end_date')
                ->orWhere('end_date', '>', now());
        })->latest()->get();

        return response()->json($this->withSuccess($data));
    }

    public function couponApply(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'utr' => 'required|string|exists:orders,utr',
            'couponCode' => 'required|string|exists:coupons,code',
        ]);
        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()));
        }
        $order = Order::own()->with(['orderDetails:id,order_id,parent_id'])
            ->where('payment_status', 0)
            ->where('utr', $request->utr)
            ->latest()->first();

        if (!$order) {
            return response()->json($this->withErrors(
               'Order not found or already paid',
            ));
        }

        if ($order->coupon_code == $request->couponCode) {
            return response()->json($this->withErrors(
                'Coupon already applied',
            ));
        }

        $coupon = Coupon::where('code', $request->couponCode)
            ->where('status', 1)
            ->where('start_date', '<=', Carbon::now())
            ->first();

        if (!$coupon || ($coupon->end_date && $coupon->end_date < Carbon::now())) {
            return response()->json($this->withErrors(
                'Invalid or expired coupon',
            ));
        }

        $parentIds = $order->orderDetails->pluck('parent_id')->toArray();

        if ($order->order_for == 'topup' && empty(array_diff($coupon->top_up_list ?? [], $parentIds))) {
            return response()->json($this->withErrors(
                'You are not eligible to apply this coupon',
            ));
        }

        if ($order->order_for == 'card' && empty(array_diff($coupon->card_list ?? [], $parentIds))) {
            return response()->json($this->withErrors(
                'You are not eligible to apply this coupon',
            ));
        }

        if (!$coupon->is_unlimited && $coupon->used_limit <= $coupon->total_use) {
            return response()->json($this->withErrors(
                'Coupon usage limit reached',
            ));

        }

        $discount = $coupon->discount;
        if ($coupon->discount_type == 'percent') {
            $discount = ($order->amount * $coupon->discount) / 100;
        }

        $order->coupon_id = $coupon->id;
        $order->coupon_code = $coupon->code;
        $order->amount = (($order->amount + $order->discount) - $discount);
        $order->discount = $discount;
        $order->save();
        return response()->json($this->withSuccess([
            'status' => 'success',
            'discount' => getAmount($discount, 2),
            'amount' => getAmount($order->amount, 2),
            'total_amount' => userCurrencyPosition($order->amount),
            'message' => "You get " . userCurrencyPosition($discount) . " discount",
            ]));

    }

}
