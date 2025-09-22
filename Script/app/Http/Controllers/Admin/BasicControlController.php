<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Facades\App\Services\BasicService;
use Facades\App\Services\CurrencyLayerService;
use Exception;

class BasicControlController extends Controller
{
    public function index($settings = null)
    {
        $settings = $settings ?? 'settings';
        abort_if(!in_array($settings, array_keys(config('generalsettings'))), 404);
        $settingsDetails = config("generalsettings.{$settings}");
        return view('admin.control_panel.settings', compact('settings', 'settingsDetails'));
    }

    public function basicControl()
    {
        $data['basicControl'] = basicControl();
        $data['timeZones'] = timezone_identifiers_list();
        $data['dateFormat'] = config('dateformat');
        return view('admin.control_panel.basic_control', $data);
    }

    public function basicControlUpdate(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|min:1|max:100',
            'time_zone' => 'required|string',
            'base_currency' => 'required|string|min:1|max:100',
            'currency_symbol' => 'required|string|min:1|max:100',
            'fraction_number' => 'required|integer|not_in:0',
            'paginate' => 'required|integer|not_in:0',
            'date_format' => 'required|string',
            'contact_number' => 'required|max:20',
            'payment_released' => 'required|max:20',
            'payment_expired' => 'required|max:20',
            'admin_prefix' => 'required|string|min:3|max:100',
            'light_primary_color' => 'required|string',
            'dark_primary_color' => 'required|string',
        ]);

        try {
            $basic = BasicControl();
            $response = BasicControl::updateOrCreate([
                'id' => $basic->id ?? ''
            ], [
                'site_title' => $request->site_title,
                'time_zone' => $request->time_zone,
                'base_currency' => $request->base_currency,
                'currency_symbol' => $request->currency_symbol,
                'fraction_number' => $request->fraction_number,
                'date_time_format' => $request->date_format,
                'contact_number' => $request->contact_number,
                'payment_released' => $request->payment_released,
                'payment_expired' => $request->payment_expired,
                'paginate' => $request->paginate,
                'admin_prefix' => $request->admin_prefix,
                'light_primary_color' => $request->light_primary_color,
                'dark_primary_color' => $request->dark_primary_color,
            ]);

            if (!$response)
                throw new Exception('Something went wrong, when updating data');

            $env = [
                'APP_TIMEZONE' => $response->time_zone,
                'APP_DEBUG' => $response->error_log == 0 ? 'true' : 'false'
            ];

            BasicService::setEnv($env);
            session()->flash('success', 'Basic control has been successfully configured');
            Artisan::call('optimize:clear');
            return back();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function basicControlActivityUpdate(Request $request)
    {
        $request->validate([
            'strong_password' => 'nullable|numeric|in:0,1',
            'registration' => 'nullable|numeric|in:0,1',
            'error_log' => 'nullable|numeric|in:0,1',
            'card' => 'nullable|numeric|in:0,1',
            'top_up' => 'nullable|numeric|in:0,1',
            'sell_post' => 'nullable|numeric|in:0,1',
            'is_active_cron_notification' => 'nullable|numeric|in:0,1',
            'has_space_between_currency_and_amount' => 'nullable|numeric|in:0,1',
            'is_force_ssl' => 'nullable|numeric|in:0,1',
            'is_currency_position' => 'nullable|string|in:left,right'
        ]);

        try {
            $basic = BasicControl();
            $response = BasicControl::updateOrCreate([
                'id' => $basic->id ?? ''
            ], [
                'error_log' => $request->error_log,
                'strong_password' => $request->strong_password,
                'registration' => $request->registration,
                'card' => $request->card,
                'top_up' => $request->top_up,
                'sell_post' => $request->sell_post,
                'is_active_cron_notification' => $request->is_active_cron_notification,
                'has_space_between_currency_and_amount' => $request->has_space_between_currency_and_amount,
                'is_currency_position' => $request->is_currency_position,
                'is_force_ssl' => $request->is_force_ssl
            ]);

            if (!$response)
                throw new Exception('Something went wrong, when updating the data.');

            session()->flash('success', 'Basic control has been successfully configured.');
            Artisan::call('optimize:clear');
            return back();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function currencyExchangeApiConfig()
    {
        $data['scheduleList'] = config('schedulelist.schedule_list');
        $data['basicControl'] = basicControl();
        return view('admin.control_panel.exchange_api_setting', $data);
    }

    public function currencyExchangeApiConfigUpdate(Request $request)
    {
        try {
            $basicControl = basicControl();
            $basicControl->update([
                'currency_layer_access_key' => $request->currency_layer_access_key,
                'currency_layer_auto_update' => $request->currency_layer_auto_update,
                'currency_layer_auto_update_at' => $request->currency_layer_auto_update_at,
                'coin_market_cap_app_key' => $request->coin_market_cap_app_key,
                'coin_market_cap_auto_update' => $request->coin_market_cap_auto_update,
                'coin_market_cap_auto_update_at' => $request->coin_market_cap_auto_update_at,
            ]);
            return back()->with('success', 'Configuration changes successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function basicControlTableViewUpdate(Request $request)
    {
        $this->validate($request, [
            'table_view' => 'required|in:flex,scrolling',
        ]);

        $basic = BasicControl();
        BasicControl::updateOrCreate([
            'id' => $basic->id ?? ''
        ], [
            'table_view' => $request->table_view,
        ]);

        return back()->with('success', ucfirst($request->table_view) . ' Version Applied Successfully');
    }
    public function appControl(Request $request)
    {
        $basicControl = basicControl();
        if ($request->method() == 'GET') {
            return view('admin.control_panel.app_control', compact('basicControl'));
        } elseif ($request->method() == 'POST') {
            try {
                $response = BasicControl::updateOrCreate([
                    'id' => $basicControl->id ?? ''
                ], [
                    'app_color' => $request->app_color,
                    'app_version' => $request->app_version,
                    'app_build' => $request->app_build,
                    'is_major' => $request->is_major,
                ]);

                if (!$response)
                    throw new Exception('Something went wrong, when updating the data.');

                session()->flash('success', 'App control has been successfully configured.');
                Artisan::call('optimize:clear');
                return back();
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }
    }
}
