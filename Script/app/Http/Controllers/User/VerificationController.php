<?php

namespace App\Http\Controllers\User;

use App\Helpers\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Models\ContentDetails;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VerificationController extends Controller
{

    use Notify;


    public function checkValidCode($user, $code, $add_min = 10000)
    {
        if (!$code) return false;
        if (!$user->sent_at) return false;
        if (Carbon::parse($user->sent_at)->addMinutes($add_min) < Carbon::now()) return false;
        if ($user->verify_code !== $code) return false;
        return true;
    }

    public function check()
    {
        $user = auth()->user();
        $template = ContentDetails::whereHas('content', function ($query) {
            $query->whereIn('name', ['authentication']);
        })->get()->groupBy('content.name');

        if (!$user->status) {
            Auth::guard('web')->logout();
        } elseif (!$user->email_verification) {
            if (!$this->checkValidCode($user, $user->verify_code)) {
                $user->verify_code = code(6);
                $user->sent_at = Carbon::now();
                $user->save();
                $this->mail($user, 'VERIFICATION_CODE', [
                    'code' => $user->verify_code
                ], null, null);
                session()->flash('success', 'Email verification code has been sent');
            }
            $page_title = 'Email Verification';
            return view(template() . 'auth.verification.email', compact('user', 'page_title', 'template'));
        } elseif (!$user->sms_verification) {
            if (!$this->checkValidCode($user, $user->verify_code)) {
                $user->verify_code = code(6);
                $user->sent_at = Carbon::now();
                $user->save();

                $this->verifyToSms($user, 'VERIFICATION_CODE', [
                    'code' => $user->verify_code
                ]);
                session()->flash('success', 'SMS verification code has been sent');
            }
            $page_title = 'SMS Verification';
            return view(template() . 'auth.verification.sms', compact('user', 'page_title', 'template'));
        } elseif (!$user->two_fa_verify) {
            $page_title = '2FA Code';
            return view(template() . 'auth.verification.2stepSecurity', compact('user', 'page_title', 'template'));

        }
        return redirect()->route('user.dashboard');
    }


    public function resendCode()
    {
        $type = request()->type;
        $user = auth()->user();
        if ($this->checkValidCode($user, $user->verify_code, 2)) {
            $target_time = Carbon::parse($user->sent_at)->addMinutes(2)->timestamp;
            $delay = $target_time - time();
            throw ValidationException::withMessages(['resend' => 'Please Try after ' . gmdate("i:s", $delay) . ' minutes']);
        }
        if (!$this->checkValidCode($user, $user->verify_code)) {
            $user->verify_code = code(6);
            $user->sent_at = Carbon::now();
            $user->save();
        } else {
            $user->sent_at = Carbon::now();
            $user->save();
        }

        if ($type === 'email') {
            $this->mail($user, 'VERIFICATION_CODE', [
                'code' => $user->verify_code
            ], null, null);
            return back()->with('success', 'Email verification code has been sent.');
        } elseif ($type === 'mobile') {
            $this->verifyToSms($user, 'VERIFICATION_CODE', [
                'code' => $user->verify_code
            ]);
            return back()->with('success', 'SMS verification code has been sent');
        } else {
            throw ValidationException::withMessages(['error' => 'Sending Failed']);
        }
    }

    public function mailVerify(Request $request)
    {
        // Define validation rules and custom error messages
        $rules = [
            'code' => 'required',
        ];
        $msg = [
            'code.required' => 'Email verification code is required',
        ];

        $this->validate($request, $rules, $msg);

        $user = auth()->user();

        if ($this->checkValidCode($user, $request->code)) {
            $user->email_verification = 1;
            $user->verify_code = null;
            $user->sent_at = null;
            $user->save();

            return redirect()
                ->intended(route('user.dashboard'))
                ->with('success', __('Email verified successfully!'));
        }

        throw ValidationException::withMessages([
            'error' => __('Verification code didn\'t match!'),
        ]);
    }


    public function smsVerify(Request $request)
    {
        $rules = [
            'code' => 'required',
        ];
        $msg = [
            'code.required' => 'Sms verification code is required',
        ];
        $validate = $this->validate($request, $rules, $msg);
        $user = Auth::user();

        if ($this->checkValidCode($user, $request->code)) {
            $user->sms_verification = 1;
            $user->verify_code = null;
            $user->sent_at = null;
            $user->save();

            return redirect()->intended(route('user.dashboard'));
        }
        throw ValidationException::withMessages(['error' => 'Verification code didn\'t match!']);
    }

    public function twoFAverify(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ], [
            'code.required' => 'Email verification code is required',
        ]);
        $ga = new GoogleAuthenticator();
        $user = Auth::user();
        $getCode = $ga->getCode($user->two_fa_code);
        if ($getCode == trim($request->code)) {
            $user->two_fa_verify = 1;
            $user->save();
            return redirect()->intended(route('user.dashboard'));
        }
        throw ValidationException::withMessages(['error' => 'Wrong Verification Code']);

    }


}
