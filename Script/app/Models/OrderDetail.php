<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['image_path'];
    protected $casts = [
        'code' => 'array'
    ];

    public function getImagePathAttribute()
    {
        return getFile($this->image_driver, $this->image);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailable()
    {
        return $this->morphTo();
    }
}
