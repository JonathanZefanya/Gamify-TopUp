<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'info' => 'object'
    ];

    public function scopeOwn($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopePayment($query)
    {
        return $query->where('payment_status', 1);
    }

    public function scopeType($query, $type)
    {
        return $query->where('order_for', $type);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class,'payment_method_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating(function (Order $order) {
            if (empty($order->utr)) {
                $order->utr = self::generateOrderNumber();
            }
        });
    }

    public static function generateOrderNumber()
    {
        return DB::transaction(function () {
            $lastOrder = self::lockForUpdate()->orderBy('id', 'desc')->first();
            if ($lastOrder && isset($lastOrder->trx_id)) {
                $lastOrderNumber = (int)filter_var($lastOrder->trx_id, FILTER_SANITIZE_NUMBER_INT);
                $newOrderNumber = $lastOrderNumber + 1;
            } else {
                $newOrderNumber = strRandomNum(12);
            }

            while (self::where('utr', 'O' . $newOrderNumber)->exists()) {
                $newOrderNumber = (int)$newOrderNumber + 1;
            }
            return 'O' . $newOrderNumber;
        });
    }
}
