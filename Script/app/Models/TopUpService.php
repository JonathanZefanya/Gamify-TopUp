<?php

namespace App\Models;

use App\Scopes\EnsureTopUpIdScope;
use App\Traits\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUpService extends Model
{
    use HasFactory, Upload;

    protected $guarded = ['id'];
    protected $appends = ['image_path'];
    protected $casts = [
        'old_data' => 'object',
        'campaign_data' => 'object',
    ];

    protected static function booted()
    {
        static::saved(function ($model) {
            if (!isset($model->top_up_id)) {
                static::addGlobalScope(new EnsureTopUpIdScope);
                $model->refresh();
            }
            dispatch(new \App\Jobs\UpdateChildCountJob($model->topUp->category_id, 'top_up'));
        });
    }

    public function topUp()
    {
        return $this->belongsTo(TopUp::class, 'top_up_id');
    }

    public function getImagePathAttribute()
    {
        return getFile($this->image_driver, $this->image);
    }


    public function imagePath()
    {
        return getFile($this->image_driver, $this->image);
    }

    public function setImageAttribute($image)
    {
        if ($image) {
            $uploadedImage = $this->fileUpload($image, config('filelocation.topUpService.path'), null, config('filelocation.topUpService.size'), 'webp', 60);
            if ($uploadedImage) {
                $this->attributes['image'] = $uploadedImage['path'];
                $this->attributes['image_driver'] = $uploadedImage['driver'];
            }
        }
    }

    public function getDiscount()
    {
        $discount = 0;
        if ($this->discount && $this->price) {
            if ($this->discount_type == 'percentage') {
                $discount = ($this->discount * $this->price) / 100;
            } elseif ($this->discount_type == 'flat') {
                $discount = $this->discount;
            }
        }
        return round($discount, 2);
    }

    public function orderDetails()
    {
        return $this->morphMany(OrderDetail::class, 'detailable');
    }
}
