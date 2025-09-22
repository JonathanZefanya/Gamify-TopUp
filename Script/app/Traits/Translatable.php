<?php


namespace App\Traits;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait Translatable
{
    public static function booted()
    {
        if (Auth::getDefaultDriver() != 'admin') {
            $lang = app()->getLocale();
            $languageTr = \Cache::rememberForever("languageTr_{$lang}", function () use ($lang) {
                return Language::where('short_name', $lang)->first();
            });

            $languageId = $languageTr ?: Language::where('default_status', true)->first();

            if ($languageId) {
                static::addGlobalScope('language', function (Builder $builder) use ($languageId) {
                    $builder->where('language_id', $languageId->id);
                });
            }
        }
    }
}
