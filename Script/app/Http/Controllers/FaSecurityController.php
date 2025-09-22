<?php

namespace App\Http\Controllers;

use App\Helpers\GoogleAuthenticator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use App\Traits\Notify;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Http\Request;

class FaSecurityController extends Controller
{
    use Notify;


    public function twoStepSecurity()
    {
        $basic = basicControl();
        $user = auth()->user();
        $google2fa = new Google2FA();
        $secret = $user->two_fa_code ?? $this->generateSecretKeyForUser($user);

        // Generate QR code URL
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            auth()->user()->username,
            $basic->site_title,
            $secret
        );
        return view(template() . 'user.'.getDash().'.twoFA.index', compact('secret', 'qrCodeUrl'));
    }

    public function twoStepRegenerate()
    {
        $user = auth()->user();
        $user->two_fa_code = null;
        $user->save();
        session()->flash('success','Re-generate Successfully');
        return redirect()->route('user.twostep.security');
    }

    private function generateSecretKeyForUser(User $user)
    {
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        $user->update(['two_fa_code' => $secret]);

        return $secret;
    }

    public function twoStepEnable(Request $request)
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
                'code' => $user->two_fa_code,
                'ip' => request()->ip(),
                'time' => date('d M, Y h:i:s A'),
            ]);

            return back()->with('success', 'Google Authenticator Has Been Enabled.');
        } else {
            return back()->with('error', 'Wrong Verification Code.');
        }
    }


    public function twoStepDisable(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Incorrect password. Please try again.');
        }

        auth()->user()->update([
            'two_fa' => 0,
            'two_fa_verify' => 1,
        ]);

        $user = auth()->user();
        $this->mail($user, 'TWO_STEP_DISABLED', [
            'time' => date('d M, Y h:i:s A'),
        ]);
        return redirect()->route('user.dashboard')->with('success', 'Two-step authentication disabled successfully.');
    }
}
