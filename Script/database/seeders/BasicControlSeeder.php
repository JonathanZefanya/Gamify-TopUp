<?php

namespace Database\Seeders;

use App\Models\BasicControl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BasicControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('basic_controls')->insert([
            'theme' => 'light',
            'site_title' => 'Gamers Haven',
            'primary_color' => '#ffc800',
            'secondary_color' => '#000000',
            'time_zone' => 'Asia/Dhaka',
            'base_currency' => 'BDT',
            'currency_symbol' => '৳',
            'admin_prefix' => 'admin',
            'is_currency_position' => 'left',
            'has_space_between_currency_and_amount' => 0,
            'is_force_ssl' => 0,
            'is_maintenance_mode' => 0,
            'paginate' => 20,
            'strong_password' => 0,
            'registration' => 1,
            'fraction_number' => 2,
            'sender_email' => 'gamers@gmail.com',
            'sender_email_name' => 'Bug Admin',
            'email_description' => config('email-description'),
            'push_notification' => 0,
            'in_app_notification' => 1,
            'active_in_app' => 'pusher',
            'email_notification' => 1,
            'email_verification' => 0,
            'sms_notification' => 1,
            'sms_verification' => 0,
            'tawk_id' => 'OSLDSF465DD',
            'tawk_status' => 0,
            'fb_messenger_status' => 0,
            'fb_app_id' => 'KLSDKF789',
            'fb_page_id' => '654646977',
            'manual_recaptcha' => 0,
            'google_recaptcha' => 0,
            'recaptcha_admin_login' => 1,
            'google_reCapture_admin_login' => 1,
            'google_reCaptcha_status_login' => 1,
            'google_recaptcha_admin_login' => 1,
            'google_reCaptcha_status_registration' => 1,
            'reCaptcha_status_login' => 1,
            'reCaptcha_status_registration' => 1,
            'measurement_id' => 'aaaaaa',
            'analytic_status' => 1,
            'error_log' => 0,
            'is_active_cron_notification' => 0,
            'logo' => 'logo/aCsL2fNLARAGgZiSWHXY9HKJed8qtL.avif',
            'logo_driver' => 'local',
            'favicon' => 'logo/s3hCvGGP4LK5xLSNJcd9MU5WAP6CZr.avif',
            'favicon_driver' => 'local',
            'admin_logo' => 'logo/Nf4PIoMDMfjj7iAf2cV7Ak0lGwNHgq.avif',
            'admin_logo_driver' => 'local',
            'admin_dark_mode_logo' => 'logo/zCIpNCzYXyobXDGIYecsD8xLim82Jz.avif',
            'admin_dark_mode_logo_driver' => 'local',
            'date_time_format' => 'd M Y',
        ]);
    }
}
