<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Language as LanguageModel;
use Illuminate\Support\Facades\DB;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        session()->put('lang', $this->getCode());
        session()->put('rtl', $this->getDirection());
        app()->setLocale(session('lang', $this->getCode()));
        return $next($request);
    }

    public function getCode()
    {
        if (session()->has('lang')) {
            return session('lang');
        }
        try {
            DB::connection()->getPdo();

            $language = LanguageModel::where('status', 1)->where('default_status', 1)->first();
            if (!$language) {
                $language = LanguageModel::where('status', 1)->first();
            }
            return $language ? $language->short_name : 'en';
        } catch (\Exception $exception) {

        }
    }

    public function getDirection()
    {
        if (session()->has('rtl')) {
            return session('rtl');
        }
        try {
            DB::connection()->getPdo();

            $language = LanguageModel::where('status', 1)->where('default_status', 1)->first();
            if (!$language) {
                $language = LanguageModel::where('status', 1)->first();
            }
            return $language ? $language->rtl : 0;
        } catch (\Exception $exception) {

        }
    }
}
