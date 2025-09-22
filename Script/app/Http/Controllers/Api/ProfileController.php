<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\UserAllRecordDeleteJob;
use App\Models\FireBaseToken;
use App\Models\Kyc;
use App\Models\Language;
use App\Models\User;
use App\Models\UserKyc;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    use ApiValidation, Notify, Upload;

    public function profile(Request $request)
    {
        try {
            $user = auth()->user();
            $data['userImage'] = getFile($user->image_driver, $user->image);
            $data['userJoinDate'] = $user->created_at ?? null;
            $data['userFirstName'] = $user->firstname ?? null;
            $data['userLastName'] = $user->lastname ?? null;
            $data['userUsername'] = $user->username ?? null;
            $data['userEmail'] = $user->email ?? null;
            $data['userPhoneCode'] = $user->phone_code ?? null;
            $data['userPhone'] = $user->phone ?? null;
            $data['userLanguageId'] = $user->language_id ?? null;
            $data['userAddress'] = $user->address_one ?? null;
            $data['timezone'] = $user->timezone ?? null;

            $data['languages'] = Language::all()->map(function ($query) {
                $query->flag = getFile($query->flag_driver, $query->flag);
                return $query;
            });

            $data['userKyc'] = UserKyc::where('user_id', Auth::user()->id)->where('status', 1)->pluck('kyc_id');
            $data['kycs'] = Kyc::where('status', 1)->get();
            return response()->json($this->withSuccess($data));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function profileImageUpload(Request $request)
    {
        $allowedExtensions = array('jpg', 'png', 'jpeg');
        $image = $request->image;
        $this->validate($request, [
            'image' => [
                'required',
                'max:10240',
                function ($fail) use ($image, $allowedExtensions) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (($image->getSize() / 1000000) > 2) {
                        return response()->json($this->withErrors('Images MAX  10MB ALLOW!'));
                    }
                    if (!in_array($ext, $allowedExtensions)) {
                        return response()->json($this->withErrors('Only png, jpg, jpeg images are allowed'));
                    }
                }
            ]
        ]);
        $user = Auth::user();
        if ($request->hasFile('image')) {
            $image = $this->fileUpload($request->image, config('filelocation.userProfile.path'), null, config('filelocation.userProfile.size'), 'webp', null, $user->image, $user->image_driver);
            if ($image) {
                $profileImage = $image['path'];
                $ImageDriver = $image['driver'];
            }
        }
        $user->image = $profileImage ?? $user->image;
        $user->image_driver = $ImageDriver ?? $user->image_driver;
        $user->save();
        return response()->json($this->withSuccess('Updated Successfully.'));

    }

    public function profileInfoUpdate(Request $request)
    {
        try {
            $languages = Language::all()->map(function ($item) {
                return $item->id;
            });
            $user = auth()->user();
            $validateUser = Validator::make($request->all(),
                [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'username' => "sometimes|required|alpha_dash|min:5|unique:users,username," . $user->id,
                    'address' => 'required',
                    'language_id' => Rule::in($languages),
                ]);

            if ($validateUser->fails()) {
                return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
            }

            $user->language_id = $request['language_id'];
            $user->firstname = $request['firstname'];
            $user->lastname = $request['lastname'];
            $user->username = $request['username'];
            $user->address_one = $request['address'];
            $user->timezone = $request['timezone'];
            $user->save();

            return response()->json($this->withSuccess('Updated Successfully.'));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function profilePassUpdate(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'current_password' => "required",
                'password' => "required|min:5|confirmed",
            ]);

        if ($validateUser->fails()) {
            return response()->json($this->withErrors(collect($validateUser->errors())->collapse()));
        }

        $user = auth()->user();
        try {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();

                return response()->json($this->withSuccess('Password Changes successfully.'));
            } else {
                return response()->json($this->withErrors('Current password did not match'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function kycSubmit(Request $request)
    {
        $kyc = Kyc::where('status', 1)->findOrFail($request->id);
        $oldKyc = UserKyc::where('kyc_id', $kyc->id)->where('user_id', Auth::user()->id)->first();
        try {
            $params = $kyc->input_form;
            $reqData = $request->except('_token', '_method');
            $rules = [];
            if ($params !== null) {
                foreach ($params as $key => $cus) {
                    $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
                    if ($cus->type == 'file') {
                        $rules[$key][] = 'image';
                        $rules[$key][] = 'mimes:jpeg,jpg,png';
                        $rules[$key][] = 'max:10240';
                    } elseif ($cus->type == 'text') {
                        $rules[$key][] = 'max:191';
                    } elseif ($cus->type == 'number') {
                        $rules[$key][] = 'integer';
                    } elseif ($cus->type == 'textarea') {
                        $rules[$key][] = 'min:3';
                        $rules[$key][] = 'max:300';
                    }
                }
            }
            $validator = Validator::make($reqData, $rules);
            if ($validator->fails()) {
                return response()->json($this->withErrors(collect($validator->errors())->collapse()));
            }
            $reqField = [];
            foreach ($request->except('_token', '_method', 'type') as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k == $inKey) {
                        if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                            try {
                                $file = $this->fileUpload($request[$inKey], config('filelocation.kyc.path'), null, null, 'webp', 60);
                                $reqField[$inKey] = [
                                    'field_label' => $inVal->field_name,
                                    'field_value' => $file['path'],
                                    'field_driver' => $file['driver'],
                                    'validation' => $inVal->validation,
                                    'type' => $inVal->type,
                                ];
                            } catch (\Exception $exp) {
                                return response()->json($this->withErrors('Could not upload your ' . $inKey));
                            }
                        } else {
                            $reqField[$inKey] = [
                                'field_label' => $inVal->field_name,
                                'validation' => $inVal->validation,
                                'field_value' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }

            if (isset($oldKyc) && $oldKyc->status == 0) {
                $oldKyc->kyc_info = $reqField;
                $oldKyc->status = 0;
                $oldKyc->save();

                return response()->json($this->withSuccess('KYC Updated Successfully'));
            }else{
                UserKyc::create([
                    'user_id' => auth()->id(),
                    'kyc_id' => $kyc->id,
                    'kyc_type' => $kyc->name,
                    'kyc_info' => $reqField
                ]);

                return response()->json($this->withSuccess('KYC Submitted Successfully'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function accountDelete(Request $request)
    {
        $user = auth()->user();
        if (config('demo.IS_DEMO') == true && $user->id ==1) {
            return response()->json('This feature is not available in demo mode');
        }
        if ($user) {
            UserAllRecordDeleteJob::dispatch($user);
            $user->forceDelete();
            return response()->json($this->withSuccess('Account has been deleted'));
        }

        return response()->json('You are not eligible for take action');
    }

    public function firebaseTokenSave(Request $request)
    {
        if (!$request->fcm_token) {
            return response()->json($this->withErrors('FCM Token is required'));
        }

        try {
            $user = auth()->user();
            FireBaseToken::firstOrCreate(
                [
                    'token' => $request->fcm_token
                ],
                [
                    'tokenable_id' => $user->id,
                    'tokenable_type' => User::class,
                ]
            );
            return response()->json($this->withSuccess('FCM Token saved'));
        } catch (\Exception $exception) {
            return response()->json($this->withErrors($exception->getMessage()));
        }
    }
}
