<?php

namespace App\Services\Google;

use Illuminate\Support\Facades\Http;

class GoogleRecaptchaService
{

    public function responseRecaptcha($response)
    {
        try {
            $response = Http::asForm()->post(env("GOOGLE_RECAPTCHA_SITE_VERIFY_URL"), [
                'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                'response' => $response,
            ]);

            $result = $response->json();

            if ($result['success']) {
                return true;
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
