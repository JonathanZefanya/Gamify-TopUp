<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageMenu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_section', 'menu_items'];
    protected $casts = ['menu_items' => 'array'];

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            \Cache::forget('headerMenu');
            \Cache::forget('footerMenu');
        });
    }
}
