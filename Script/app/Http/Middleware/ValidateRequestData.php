<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class ValidateRequestData
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $preventFrom = ['email_template', 'email_description', 'guide', 'description'];
        foreach ($request->all() as $key => $req) {
            unset($request['filepond']);
            if (!$request->hasFile($key) && !in_array($key, $preventFrom)) {
                $request[$key] = isset($req) ? Purify::clean($req) : null;
            }
        }
        return $next($request);
    }
}
