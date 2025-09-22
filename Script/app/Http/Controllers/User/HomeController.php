<?php

namespace App\Http\Controllers\User;


use App\Helpers\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Jobs\UserTrackingJob;
use App\Models\Card;
use App\Models\CardService;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Kyc;
use App\Models\Language;
use App\Models\Order;
use App\Models\Payout;
use App\Models\SellPost;
use App\Models\SellPostOffer;
use App\Models\SellPostPayment;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\UserKyc;
use App\Rules\PhoneLength;
use App\Traits\Upload;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Stevebauman\Purify\Facades\Purify;


class HomeController extends Controller
{
    use Upload;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function saveToken(Request $request)
    {
        try {
            Auth::user()
                ->fireBaseToken()
                ->create([
                    'token' => $request->token,
                ]);
            return response()->json([
                'msg' => 'token saved successfully.',
            ]);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function index()
    {
        $data['user'] = Auth::user();

        $data['stat'] = Order::payment()->own()
            ->selectRaw('COUNT(CASE WHEN order_for = "topup" THEN id END) AS totalTopUpOrder')
            ->selectRaw('COUNT(CASE WHEN order_for = "card" THEN id END) AS totalCardOrder')
            ->first();
        $data['sellPostOffer'] = SellPostOffer::where('author_id', auth()->user()->id)
            ->whereHas('sellPost')->whereHas('user')->with(['sellPost', 'user:id,firstname,lastname,image,image_driver'])->latest()->take(3)->get();

        $data['sellPost'] = SellPost::whereUser_id(Auth()->user()->id)
            ->with('category.details')->latest()->take(3)->get();

        $data['totalTickets'] = SupportTicket::where('user_id', $data['user']->id)->count();

        $data['firebaseNotify'] = config('firebase');

        $data['topSlider'] = CardService::where('status', 1)->where('is_offered', 1)->latest()->take(5)->get();

        return view(template() . "user." . getDash() . ".dashboard", $data);
    }


    public function profile()
    {
        $data['languages'] = Language::all();
        $data['userProfile'] = $this->user;
        return view(template() . "user." . getDash() . ".profile.my_profile", $data);
    }

    public function profileUpdateImage(Request $request)
    {
        $userProfile = $this->user;
        if ($request->file('image') && $request->file('image')->isValid()) {
            $extension = $request->image->extension();
            $profileName = strtolower($userProfile->username . '.' . $extension);
            $image = $this->fileUpload($request->image, config('filelocation.userProfile.path'), $profileName, null, 'webp', 60, $userProfile->image, $userProfile->image_driver);
            if ($image) {
                $userProfile->image = $image['path'];
                $userProfile->image_driver = $image['driver'];
            }
        }

        $remark = 'Update profile image';
        UserTrackingJob::dispatch($userProfile->id, request()->ip(), $remark);

        $userProfile->save();
        return back()->with('success', 'Uploaded Successfully.');
    }

    public function profileUpdate(Request $request)
    {
        $purifiedData = $request->all();
        $userProfile = $this->user;
        $validator = Validator::make($purifiedData, [
            'firstname' => 'required|min:3|max:100|string',
            'lastname' => 'required|min:3|max:100|string',
            'username' => 'sometimes|required|min:5|max:50|unique:users,username,' . $userProfile->id,
            'email' => 'sometimes|required|min:5|max:50|unique:users,email,' . $userProfile->id,
            'language' => 'required|integer|not_in:0|exists:languages,id',
            'timezone' => 'required',
            'address' => 'nullable|max:2500',
            'phone' => ['required', 'string', "unique:users,phone, $userProfile->id", new PhoneLength($request->input('phone_code'))],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $purifiedData = (object)$purifiedData;
            if ($purifiedData->email != $userProfile->email) {
                $userProfile->email_verification = 0;
            }
            if ($purifiedData->phone != $userProfile->phone) {
                $userProfile->sms_verification = 0;
            }

            $userProfile->firstname = $purifiedData->firstname;
            $userProfile->lastname = $purifiedData->lastname;
            $userProfile->username = $purifiedData->username;
            $userProfile->email = $purifiedData->email;
            $userProfile->address_one = $purifiedData->address ?? null;
            $userProfile->phone = $purifiedData->phone;
            $userProfile->phone_code = $purifiedData->phone_code ?? $userProfile->phone_code;
            $userProfile->language_id = $purifiedData->language;
            $userProfile->timezone = $purifiedData->timezone;
            $userProfile->country_code = Str::upper($purifiedData->country_code);
            $userProfile->country = $purifiedData->country;

            $userProfile->save();

            $remark = 'Update profile information';
            UserTrackingJob::dispatch($userProfile->id, request()->ip(), $remark);

            return back()->with('success', 'Profile Update Successfully');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function updatePassword(Request $request)
    {
        if ($request->method() == 'GET') {
            $data['userProfile'] = $this->user;

            return view(template() . "user." . getDash() . ".profile.password", $data);
        } elseif ($request->method() == 'POST') {
            $purifiedData = $request->all();
            $validator = Validator::make($purifiedData, [
                'currentPassword' => 'required|min:5',
                'password' => 'required|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            try {
                $user = Auth::user();
                $purifiedData = (object)$purifiedData;

                if (!Hash::check($purifiedData->currentPassword, $user->password)) {
                    return back()->withInput()->withErrors(['currentPassword' => 'current password did not match']);
                }

                $user->password = bcrypt($purifiedData->password);
                $user->save();

                $remark = 'Updated password';
                UserTrackingJob::dispatch($user->id, request()->ip(), $remark);

                return back()->with('success', 'Password changed successfully');
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }
    }

    public function kycSettings()
    {
        try {
            $data['kyc'] = Kyc::where('status', 1)->get();

            return view(template() . "user." . getDash() . ".profile.kyc", $data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function addFund()
    {
        $data['basic'] = basicControl();
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();

        return view(template() . "user." . getDash() . ".fund.add_fund", $data);
    }

    public function paymentLog(Request $request)
    {
        $dateSearch = $request->created_at;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $data['logs'] = Deposit::with(['gateway:id,name,image,driver'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['1', '2', '3'])
            ->when($request->trxId, function ($query) {
                return $query->where('trx_id', 'LIKE', '%' . request('trxId') . '%');
            })
            ->when($request->amount, function ($query) {
                return $query->where('amount_in_base', 'LIKE', '%' . request('amount') . '%');
            })
            ->when($request->gateway_id, function ($query) {
                return $query->where('payment_method_id', request('gateway_id'));
            })
            ->when($request->status, function ($query) {
                return $query->where('status', request('status'));
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->latest()->paginate(basicControl()->paginate);

        $data['gateways'] = Gateway::select(['id', 'name'])->orderBy('sort_by', 'asc')->get();

        return view(template() . "user." . getDash() . ".fund.index", $data);
    }

    public function transaction(Request $request)
    {
        $dateSearch = $request->created_at;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $data['transactions'] = Transaction::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->when($request->trxId, function ($query) {
                return $query->where('trx_id', 'LIKE', '%' . request('trxId') . '%');
            })
            ->when($request->amount, function ($query) {
                return $query->where('amount_in_base', 'LIKE', '%' . request('amount') . '%');
            })
            ->when($request->remark, function ($query) {
                return $query->where('remarks', 'LIKE', '%' . request('remark') . '%');
            })
            ->when($request->type, function ($query) {
                if (request('type') == 'order') {
                    return $query->where('transactional_type', Order::class);
                } elseif (request('type') == 'deposit') {
                    return $query->where('transactional_type', Deposit::class);
                }elseif (request('type') == 'payout') {
                    return $query->where('transactional_type', Payout::class);
                }elseif (request('type') == 'sellPost') {
                    return $query->where('transactional_type', SellPostPayment::class);
                }
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->latest()->paginate(basicControl()->user_paginate);

        return view(template() . "user." . getDash() . ".transaction.index", $data);
    }

    public function apiKey(Request $request)
    {
        $user = auth()->user();
        if ($request->method() == 'GET') {
            $public_key = $user->public_key;
            $secret_key = $user->secret_key;
            if (!$public_key || !$secret_key) {
                $user->public_key = 'pk' . bin2hex(random_bytes(20));
                $user->secret_key = 'sk' . bin2hex(random_bytes(20));
                $user->save();
            }

            return view(template() . 'user.'.getDash().'.api-key');
        } elseif ($request->method() == 'POST') {
            $user->public_key = 'pk' . bin2hex(random_bytes(20));
            $user->secret_key = 'sk' . bin2hex(random_bytes(20));
            $user->save();

            $remark = 'Generated API key';
            UserTrackingJob::dispatch($user->id, request()->ip(), $remark);

            return back()->with('success', 'Api key generated successfully');
        }
    }

    public function changeDashboard(Request $request)
    {
        $request->validate([
            'dashboard' => 'required|string|in:daybreak,nightfall',
        ]);

        $user = Auth::user();

        $user->active_dashboard = $request->dashboard;
        $user->save();


        return response()->json([
            'success' => true,
            'message' => "'".ucfirst($user->active_dashboard)."'".' dashboard theme selected successfully.'
        ]);
    }

}
