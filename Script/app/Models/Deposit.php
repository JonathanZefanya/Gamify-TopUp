<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Deposit extends Model
{
    use HasFactory, Prunable;

    protected $guarded = ['id'];

    protected $casts = [
        'information' => 'object'
    ];

    public function transactional()
    {
        return $this->morphOne(Transaction::class, 'transactional');
    }

    public function depositable()
    {
        return $this->morphTo();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'payment_method_id', 'id');
    }

    public function picture()
    {
        $image = optional($this->gateway)->image;
        if (!$image) {
            $firstLetter = substr(optional($this->gateway)->name, 0, 1);
            return '<div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                        <span class="avatar-initials">' . $firstLetter . '</span>
                     </div>';

        } else {
            $url = getFile(optional($this->gateway)->driver, optional($this->gateway)->image);
            return '<div class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="' . $url . '" alt="Image Description">
                     </div>';

        }
    }
    public static function boot(): void
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('paymentRecord');
        });

        static::creating(function (Deposit $deposit) {
            if (empty($deposit->trx_id)) {
                $deposit->trx_id = self::generateOrderNumber();
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

            while (self::where('trx_id', 'D' . $newOrderNumber)->exists()) {
                $newOrderNumber = (int)$newOrderNumber + 1;
            }
            return 'D' . $newOrderNumber;
        });
    }

    public function getStatusClass()
    {
        return [
                '0' => 'text-dark',
                '1' => 'text-success',
                '2' => 'text-dark',
                '3' => 'text-danger',
            ][$this->status] ?? 'text-danger';
    }

    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subDays(2));
    }

}
