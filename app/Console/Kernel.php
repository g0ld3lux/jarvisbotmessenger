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
        Commands\Messages\Schedules\Process::class,
        Commands\Bots\Variables\Initial::class,
        Commands\Recipients\Variables\Fetch::class,
        Commands\Broadcasts\Schedules\Process::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Process broadcasts
        $schedule->command('broadcasts:schedules:process')->everyMinute();

        // Process mass messages
        $schedule->command('messages:schedules:process')->everyMinute();
    }
}
