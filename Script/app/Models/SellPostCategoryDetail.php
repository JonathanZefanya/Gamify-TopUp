<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellPostCategoryDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function sellPostCategory()
    {
        return $this->belongsTo(SellPostCategory::class, 'sell_post_category_id');
    }
}
