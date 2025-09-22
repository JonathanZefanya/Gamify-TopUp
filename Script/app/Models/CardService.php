<?php

namespace App\Models;

use App\Scopes\EnsureCardIdScope;
use App\Traits\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardService extends Model
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
            if (!isset($model->card_id)) {
                static::addGlobalScope(new EnsureCardIdScope);
                $model->refresh();
            }
            dispatch(new \App\Jobs\UpdateChildCountJob($model->card->category_id, 'card'));
        });
    }

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function codes()
    {
        return $this->morphMany(Code::class, 'codeable');
    }

    public function activeCodes()
    {
        return $this->morphMany(Code::class, 'codeable')->where('status', 1);
    }

    public function setImageAttribute($image)
    {
        if ($image) {
            $uploadedImage = $this->fileUpload($image, config('filelocation.cardService.path'), null, config('filelocation.cardService.size'), 'webp', 60);
            if ($uploadedImage) {
                $this->attributes['image'] = $uploadedImage['path'];
                $this->attributes['image_driver'] = $uploadedImage['driver'];
            }
        }
    }

    public function getImagePathAttribute()
    {
        return getFile($this->image_driver, $this->image);
    }

    public function imagePath()
    {
        return getFile($this->image_driver, $this->image);
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
        return $discount;
    }
}
