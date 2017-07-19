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
        $schedule->exec('datascouts:fetch-handlers')
                 ->name('Process for Handlers\' fetching ')
                 ->everyMinute('5')
                 ->withoutOverlapping() // No run if previous cmd still running
        ;
    }
}
