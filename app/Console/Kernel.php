<?php

namespace App\Console;

use App\Console\Commands\LoadCalendars;
use App\Console\Commands\RefreshStoredTokens;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(LoadCalendars::class)
            ->everyTenMinutes()
            ->weekdays()
            ->between('08:30', '18:00');

        $schedule->command(RefreshStoredTokens::class)
            ->everyFifteenMinutes()
            ->weekdays()
            ->between('08:30', '18:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
