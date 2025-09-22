<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\User;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use ApiValidation, Notify;

    public function registerUserForm()
    {
        try {
            if (basicControl()->registration == 0) {
                return response()->json($this->withErrors("Registration Has Been Disabled."));
            }

            $info = json_decode(json_encode(getIpInfo()), true);
            $country_code = null;
            if (!empty($info['code'])) {
                $data['country_code'] = @$info['code'][0];
            }
            $data['countries'] = config('country');
            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function registerUser(Request $request)
    {
        $basic = basicControl();
        try {

            if ($basic->strong_password == 0) {
                $rules['password'] = ['required', 'min:6', 'confirmed'];
            } else {
                $rules['password'] = ["required", 'confirmed',
                    Password::min(6)->mixedCase()
                        ->letters()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()];
            }

            $rules['firstname'] = ['required', 'string', 'max:91'];
            $rules['lastname'] = ['required', 'string', 'max:91'];
            $rules['username'] = ['required', 'alpha_dash', 'min:5', 'unique:users,username'];
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email'];
            $rules['country_code'] = ['max:5'];
            $rules['phone_code'] = ['required'];
            $rules['phone'] = ['required'];
            $rules['password'] = ['required', 'min:6', 'confirmed'];

            $validateUser = Validator::make($request->all(), $rules, [
                'firstname.required' => 'First Name Field is required',
                'lastname.required' => 'Last Name Field is required',
            ]);

            if ($validateUser->fails()) {
                return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
            }

            if ($request->sponsor != null) {
                $sponsorId = User::where('username', $request->sponsor)->first();
            } else {
                $sponsorId = null;
            }

            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'email' => $request->email,
                'country_code' => $request->country_code,
                'phone_code' => $request->phone_code,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'email_verification' => ($basic->email_verification) ? 0 : 1,
                'sms_verification' => ($basic->sms_verification) ? 0 : 1,
            ]);

            $user->last_login = Carbon::now();
            $user->two_fa_verify = ($user->two_fa == 1) ? 0 : 1;
            $user->save();


            return response()->json([
                'status' => 'success',
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);


        } catch (\Throwable $th) {
            return response()->json($this->withErrors($th->getMessage()));
        }
    }

    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'username' => 'required',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
            }

            if (!Auth::attempt($request->only(['username', 'password']))) {
                return response()->json($this->withErrors('Username & Password does not match with our record.'));
            }

            $user = User::where('username', $request->username)->first();

            $user->last_login = Carbon::now();
            $user->two_fa_verify = ($user->two_fa == 1) ? 0 : 1;
            $user->save();

            if ($user->status == 0) {
                return response()->json($this->withErrors('You are banned from this application.Please contact with the administration'));
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);

        } catch (\Throwable $th) {
            return response()->json($this->withErrors($th->getMessage()));
        }
    }

    public function getEmailForRecoverPass(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
            ]);

        if ($validateUser->fails()) {
            return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
        }

        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json($this->withErrors('Email does not exit on record'));
            }

            $code = rand(10000, 99999);
            $data['email'] = $request->email;
            $data['message'] = 'OTP has been send';
            $user->verify_code = $code;
            $user->save();

            $basic = basicControl();
            $message = 'Your Password Recovery Code is ' . $code;
            $email_from = $basic->sender_email;
            @Mail::to($request->email)->send(new SendMail($email_from, "Recovery Code", $message));

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function getCodeForRecoverPass(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'code' => 'required',
                'email' => 'required|email',
            ]);

        if ($validateUser->fails()) {
            return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
        }

        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json($this->withErrors('Email does not exit on record'));
            }

            if ($user->verify_code == $request->code && $user->updated_at > Carbon::now()->subMinutes(5)) {
                $user->verify_code = null;
                $user->update_password_token = Hash::make(Str::random(10));
                $user->save();

                return response()->json($this->withSuccess($user->update_password_token));
            }

            return response()->json($this->withErrors('Invalid Code'));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function updatePass(Request $request)
    {
        if (basicControl()->strong_password == 0) {
            $rules['password'] = ['required', 'min:6', 'confirmed'];
        } else {
            $rules['password'] = ["required", 'confirmed',
                Password::min(6)->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()];
        }
        $rules['token'] = ['required'];

        $validateUser = Validator::make($request->all(), $rules);

        if ($validateUser->fails()) {
            return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
        }

        $user = User::where('update_password_token', $request->token)->first();
        if (!$user) {
            return response()->json($this->withErrors('You are not authorized to take action'));
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json($this->withSuccess('Password Updated'));
    }

    public function generateBearer(Request $request)
    {
        $publicKey = $request->header('PublicKey');
        $secretKey = $request->header('SecretKey');

        $user = User::where('public_key', $publicKey)
            ->where('secret_key', $secretKey)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid API credentials'], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Token generated successfully',
            'bearer_token' => $user->createToken("API TOKEN")->plainTextToken
        ]);
    }
}
