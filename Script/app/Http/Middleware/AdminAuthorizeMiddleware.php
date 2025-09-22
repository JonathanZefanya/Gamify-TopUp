<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthorizeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $module): Response
    {
        $permissionLists = auth()->guard('admin')->user()->role->permission ?? null;
        if (!$permissionLists) {
            return $next($request);
        }
        if (in_array(title2snake($module),$permissionLists)) {
            return $next($request);
        }

        return redirect()->route('admin.403');
    }
}
