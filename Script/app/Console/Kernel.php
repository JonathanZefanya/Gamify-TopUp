<?php

namespace App\Console;

use App\Console\Commands\AutoCurrencyUpdate;
use App\Console\Commands\CampaignCheck;
use App\Console\Commands\GatewayCurrencyUpdate;
use App\Console\Commands\PayoutCurrencyUpdateCron;
use App\Console\Commands\ReviewCount;
use App\Models\Deposit;
use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{


    protected $commands = [
        ReviewCount::class,
        CampaignCheck::class,
        GatewayCurrencyUpdate::class,
        PayoutCurrencyUpdateCron::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:campaign-check')->everyMinute();
        $schedule->command('app:review-count')->hourly();
        $schedule->command('app:gateway-currency-update')->{basicControl()->currency_layer_auto_update_at}();
        $schedule->command('payout-currency:update')
            ->{basicControl()->currency_layer_auto_update_at}();
        $schedule->command('model:prune', [
            '--model' => [Deposit::class, Order::class],
        ])->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
