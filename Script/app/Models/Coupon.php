<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'top_up_list' => 'array',
        'card_list' => 'array',
    ];

    protected $appends = ['check_status'];

    public function getCheckStatusAttribute()
    {
        if (!$this->status) {
            return 'In-Active';
        }

        if ($this->start_date < Carbon::now() && $this->end_date > Carbon::now()) {
            return 'Running';
        }

        if ($this->start_date < Carbon::now() && !$this->end_date) {
            return 'Running';
        }

        if ($this->start_date > Carbon::now()) {
            return 'Awaiting-Running';
        }

        return 'Expired';
    }
}
