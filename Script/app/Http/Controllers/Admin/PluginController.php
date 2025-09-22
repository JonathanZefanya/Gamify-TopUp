<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Facades\App\Services\BasicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\ValidationException;
use Vonage\Client\Exception\Validation;
use function GuzzleHttp\Promise\all;

class PluginController extends Controller
{
    public function pluginConfig()
    {
        $basicControl = basicControl();
        return view('admin.plugin_controls.plugin_config', compact('basicControl'));
    }

    public function tawkConfiguration()
    {
        $basicControl = basicControl();
        return view('admin.plugin_controls.tawk_control', compact('basicControl'));
    }

    public function tawkConfigurationUpdate(Request $request)
    {
        try {
            $request->validate([
                'tawk_id' => 'required|string|min:3',
                'status' => 'required|integer|in:0,1',
            ]);

            $basicControl = basicControl();
            $basicControl->update([
                "tawk_id" => $request->tawk_id,
                "tawk_status" => $request->status
            ]);

            return back()->with('success', 'Successfully Updated');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function fbMessengerConfiguration()
    {
        $basicControl = basicControl();
        return view('admin.plugin_controls.fb_messenger_control', compact('basicControl'));
    }

    public function fbMessengerConfigurationUpdate(Request $request)
    {
        try {
            $request->validate([
                'fb_app_id' => 'required|string|min:3',
                'fb_page_id' => 'required|string|min:3',
                'fb_messenger_status' => 'required|integer|min:0|in:0,1',
            ]);

            $basicControl = basicControl();
            $basicControl->update([
                "fb_app_id" => $request->fb_app_id,
                "fb_page_id" => $request->fb_page_id,
                "fb_messenger_status" => $request->fb_messenger_status
            ]);

            return back()->with('success', 'Successfully Updated');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function googleRecaptchaConfiguration()
    {
        $data['googleRecaptchaSiteKey'] = env('GOOGLE_RECAPTCHA_SITE_KEY');
        $data['googleRecaptchaSecretKey'] = env('GOOGLE_RECAPTCHA_SECRET_KEY');
        $data['googleRecaptchaSiteVerifyUrl'] = env('GOOGLE_RECAPTCHA_SITE_VERIFY_URL');
        $data['basicControl'] = basicControl();
        return view('admin.plugin_controls.google_recaptcha_control', $data);
    }

    public function googleRecaptchaConfigurationUpdate(Request $request)
    {

        try {
            $request->validate([
                'google_recaptcha_site_key' => 'required|string|min:3',
                'google_recaptcha_secret_key' => 'required|string|min:3',
                'google_recaptcha_site_verify_url' => 'required|string|min:3',
                'google_reCapture_admin_login' => 'integer|in:0,1',
                'google_reCaptcha_status_login' => 'integer|in:0,1',
                'google_reCaptcha_status_registration' => 'integer|in:0,1',
            ]);

            $basicControl = basicControl();
            $basicControl->update([
                'google_reCapture_admin_login' => $request->google_reCapture_admin_login,
                'google_reCaptcha_status_login' => $request->google_reCaptcha_status_login,
                'google_reCaptcha_status_registration' => $request->google_reCaptcha_status_registration
            ]);


            $env = [
                'GOOGLE_RECAPTCHA_SITE_KEY' => $request->google_recaptcha_site_key,
                'GOOGLE_RECAPTCHA_SECRET_KEY' => $request->google_recaptcha_secret_key,
                'GOOGLE_RECAPTCHA_SITE_VERIFY_URL' => $request->google_recaptcha_site_verify_url,
            ];

            BasicService::setEnv($env);

            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            return back()->with('success', 'Successfully Updated');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function googleAnalyticsConfiguration()
    {
        $basicControl = basicControl();
        return view('admin.plugin_controls.analytic_control', compact('basicControl'));
    }

    public function googleAnalyticsConfigurationUpdate(Request $request)
    {

        try {
            $request->validate([
                'MEASUREMENT_ID' => 'required|min:3',
                'analytic_status' => 'required|integer|in:0,1',
            ], [
                'MEASUREMENT_ID.required' => " The MEASUREMENT ID field is required.
"
            ]);

            $basicControl = basicControl();
            $basicControl->update([
                "measurement_id" => $request->MEASUREMENT_ID,
                "analytic_status" => $request->analytic_status,
            ]);

            return back()->with('success', 'Successfully Updated');

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function manualRecaptcha()
    {
        $basicControl = basicControl();
        return view('admin.plugin_controls.manual_recaptcha', compact('basicControl'));
    }

    public function manualRecaptchaUpdate(Request $request)
    {
        try {
            $request->validate([
                'admin_login_recaptcha' => 'required|integer|in:0,1',
                'user_login_recaptcha' => 'required|integer|in:0,1',
                'user_registration_recaptcha' => 'required|integer|in:0,1',
            ]);

            $basicControl = basicControl();
            $basicControl->recaptcha_admin_login = $request->admin_login_recaptcha;
            $basicControl->reCaptcha_status_login = $request->user_login_recaptcha;
            $basicControl->reCaptcha_status_registration = $request->user_registration_recaptcha;
            $basicControl->save();

            return back()->with('success', 'Successfully Updated');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function activeRecaptcha(Request $request)
    {

        try {
            $request->validate([
                'googleRecaptcha' => 'nullable|integer|in:0,1',
                'manualRecaptcha' => 'nullable|integer|in:0,1',
            ]);

            $basicControl = basicControl();
            $basicControl->google_recaptcha = $request->googleRecaptcha;
            $basicControl->manual_recaptcha = $request->manualRecaptcha;
            $basicControl->save();

            return response([
                'success' => true,
                'message' => "Recaptcha Updated Successfully"
            ]);
        } catch (\Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
