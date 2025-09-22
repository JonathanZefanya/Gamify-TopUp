<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeServiceWise($query, $model, $id)
    {
        return $query->where(['codeable_type' => $model, 'codeable_id' => $id]);
    }

    public function codeable()
    {
        return $this->morphTo();
    }

}
