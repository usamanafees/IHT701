<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Remove3MonthsOldApiLogs::class,
        \App\Console\Commands\ChargeOndeliveryStatus::class,
        \App\Console\Commands\CheckAllDaysSmsEmailBefore::class,
        \App\Console\Commands\BillingAlerts::class,
        \App\Console\Commands\SaftSchedule::class,
        \App\Console\Commands\DaysOffAlert::class,
        \App\Console\Commands\CheckAllDaysSmsEmailAfter::class,
        \App\Console\Commands\MonthlyDaysOff::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('BillingAlerts')->daily();
        $schedule->command('Remove3MonthsOldApiLogs')->monthly();
        $schedule->command('ChargeOn:DeliveryStatus')->hourly();
        //$schedule->command('CheckAllDaysSmsEmailBefore')->hourly();
        // $schedule->command('CheckAllDaysSmsEmailBefore')->everyMinute();
        $schedule->command('SaftSchedule')->monthly();
        $schedule->command('MonthlyDaysOff')->monthly();
        $schedule->command('DaysOffAlertsForManager')->daily();
       // $schedule->command('CheckAllDaysSmsEmailAfter')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
