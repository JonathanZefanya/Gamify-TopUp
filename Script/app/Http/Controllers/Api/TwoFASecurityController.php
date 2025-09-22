<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UserSystemInfo;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

class TwoFASecurityController extends Controller
{
    use ApiValidation, Notify;

    public function twoFASecurity()
    {
        $basic = basicControl();
        $user = auth()->user();
        try {
            $data['twoFactorEnable'] = auth()->user()->two_fa == 0 ? false : true;
            $google2fa = new Google2FA();
            $secret = $user->two_fa_code ?? $this->generateSecretKeyForUser($user);

            $data['qrCodeUrl'] = $google2fa->getQRCodeUrl(
                auth()->user()->username,
                $basic->site_title,
                $secret
            );
            $data['downloadApp'] = 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en';
            $data['secret'] = $secret;
            return response()->json($this->withSuccess($data));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    private function generateSecretKeyForUser(User $user)
    {
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        $user->update(['two_fa_code' => $secret]);

        return $secret;
    }

    public function twoFASecurityEnable(Request $request)
    {

        $user = auth()->user();
        $secret = auth()->user()->two_fa_code;
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret, $request->code);
        if ($valid) {
            $user['two_fa'] = 1;
            $user['two_fa_verify'] = 1;
            $user->save();

            $this->mail($user, 'TWO_STEP_ENABLED', [
                'action' => 'Enabled',
                'code' => $request->code,
                'ip' => request()->ip(),
                'browser' => UserSystemInfo::get_browsers() . ', ' . UserSystemInfo::get_os(),
                'time' => date('d M, Y h:i:s A'),
            ]);

            return response()->json($this->withSuccess('Google Authenticator Has Been Enabled.'));
        } else {
            return response()->json($this->withErrors('Wrong Verification Code.'));
        }
    }

    public function twoFASecurityDisable(Request $request)
    {
        if (!$request->password || !Hash::check($request->password, auth()->user()->password)) {
            return response()->json($this->withErrors('Incorrect password. Please try again.'));
        }

        // Disable two-factor authentication for the user
        auth()->user()->update([
            'two_fa' => 0,
            'two_fa_verify' => 1,
            //   'two_fa_code' => null, // Optionally clear the stored secret
        ]);
        return response()->json($this->withSuccess('Two-step authentication disabled successfully.'));
    }
}
