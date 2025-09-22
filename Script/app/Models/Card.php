<?php

namespace App\Models;

use App\Scopes\EnsureCategoryIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $casts = [
        'image' => 'object',
    ];
    protected $appends = ['preview_image', 'card_detail_route'];

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
            dispatch(new \App\Jobs\UpdateChildCountJob($model->category_id, 'card'));
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function services()
    {
        return $this->hasMany(CardService::class, 'card_id');
    }

    public function activeServices()
    {
        return $this->hasMany(CardService::class, 'card_id')->where('status', 1)->orderBy('sort_by', 'ASC');
    }


    public function activeCodeCount()
    {
        return $this->activeServices()
            ->withCount(['codes as active_codes_count' => function ($query) {
                $query->where('status', 1);
            }])
            ->get()
            ->sum('active_codes_count');
    }

    public function serviceWithLowestPrice()
    {
        $lowPriceData = \Cache::get('lowPriceData_' . $this->id);
        if (!$lowPriceData) {
            $lowPriceData = $this->activeServices->sortBy('price')->first() ?? new CardService();
            \Cache::put('lowPriceData_' . $this->id, $lowPriceData);
        }
        return $lowPriceData;
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

    public function getCardDetailRouteAttribute()
    {
        if (isset($this->slug)) {
            return route('card.details', $this->slug);
        }
    }
}
