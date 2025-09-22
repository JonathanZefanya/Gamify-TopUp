<?php

namespace App\Models;

use App\Traits\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, Upload;

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeSort($query)
    {
        return $query->orderBy('sort_by', 'ASC');
    }

    // Relations for dynamic counting
    public function topUps()
    {
        return $this->hasMany(TopUp::class, 'category_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'category_id');
    }

}
