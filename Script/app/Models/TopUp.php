<?php

namespace App\Models;

use App\Scopes\EnsureCategoryIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'image' => 'object',
        'order_information' => 'object',
    ];

    protected $appends = ['preview_image', 'top_up_detail_route'];

    protected static function booted()
    {
        static::saving(function ($model) {
            if (isset($model->name)) {
                $model->slug = slug($model->name);
            }
        });

        static::saved(function ($model) {
            if (!isset($model->category_id)) {
                static::addGlobalScope(new EnsureCategoryIdScope);
                $model->refresh();
            }
            dispatch(new \App\Jobs\UpdateChildCountJob($model->category_id, 'top_up'));
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function services()
    {
        return $this->hasMany(TopUpService::class, 'top_up_id');
    }

    public function activeServices()
    {
        return $this->hasMany(TopUpService::class, 'top_up_id')->where('status', 1)->orderBy('sort_by', 'ASC');
    }

    public function reviewByReviewer()
    {
        return $this->morphOne(Review::class, 'reviewable')->where('user_id', auth()->id());
    }

    public function getPreviewImageAttribute()
    {
        if (isset($this->image->preview_driver) && isset($this->image->preview)) {
            return getFile($this->image->preview_driver, $this->image->preview);
        }
    }

    public function getTopUpDetailRouteAttribute()
    {
        if (isset($this->slug)) {
            return route('topUp.details', $this->slug);
        }
    }
    public function serviceWithLowestPrice()
    {
        return $this->activeServices->sortBy('price')->first() ?? new TopUpService();
    }


}
