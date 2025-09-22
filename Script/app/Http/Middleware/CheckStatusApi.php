<?php

namespace App\Http\Middleware;

use App\Traits\ApiValidation;
use App\Traits\Notify;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatusApi
{
    use Notify, ApiValidation;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($user->sms_verification && $user->email_verification && $user->status && $user->two_fa_verify) {
            return $next($request);
        }

        if ($user->email_verification == 0) {
            if (!$user->sent_at || now()->diffInSeconds(Carbon::parse($user->sent_at)) >= 60) {
                $user->verify_code = code(6);
                $user->sent_at = now();
                $user->save();

                $this->verifyToMail($user, 'VERIFICATION_CODE', [
                    'code' => $user->verify_code
                ]);

                return response()->json($this->withErrors('Email Verification Required'));
            }
        }

        if ($user->sms_verification == 0) {
            if (!$user->sent_at || now()->diffInSeconds(Carbon::parse($user->sent_at)) >= 60) {
                $user->verify_code = code(6);
                $user->sent_at = now();
                $user->save();

                $this->verifyToSms($user, 'VERIFICATION_CODE', [
                    'code' => $user->verify_code
                ]);

                return response()->json($this->withErrors('Mobile Verification Required'));
            }
        }

        if ($user->status == 0) {
            return response()->json($this->withErrors('Your account has been suspended'), 403);
        }

        if ($user->two_fa_verify == 0) {
            return response()->json($this->withErrors('Two FA Verification Required'), 403);
        }

        // Ensure a valid response is always returned
        return $next($request);
    }

}
