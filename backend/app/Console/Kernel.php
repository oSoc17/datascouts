<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ScheduleList::class,    
        Commands\DataScoutsAddAdminUser::class,    
        Commands\DataScoutsFetchHandles::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('datascouts:fetch-handlers')
                 ->name('Process for Handlers\' fetching ')
                 ->everyFiveMinutes()
                 ->withoutOverlapping() // No run if previous cmd still running
        ;

        // Check the jobs waiting in the queue, sleep for 30sec if no job && wait 60s before kill the process
        $schedule->command('queue:work --queue=fetchers --tries=3 --timeout=60  --sleep=30')
                 ->everyMinute()
                 ->withoutOverlapping();

        // Retry all failed jobs every 15 min
        $schedule->command('queue:retry all')
         ->everyTenMinutes()
         ->withoutOverlapping();
    }
}
