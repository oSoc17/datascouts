<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;


# Source Link : http://laravelcoding.com/blog/adding-a-schedulelist-command

class ScheduleList extends Command
{
    protected $signature = 'schedule:list';
    protected $description = 'List when scheduled commands are executed.';

    /**
     * @var Schedule
     */
    protected $schedule;

    /**
     * ScheduleList constructor.
     *
     * @param Schedule $schedule
     */
    public function __construct(Schedule $schedule)
    {
        parent::__construct();

        $this->schedule = $schedule;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events = array_map(function ($event) {
            // dd(($event->description));
            return [
                'cron' => $event->expression,
                'command' => static::fixupCommand($event->command),
                'description' => $event->description
            ];
        }, $this->schedule->events());

        $this->table(
            ['Cron', 'Command', 'Description'],
            $events
        );
    }

    /**
     * If it's an artisan command, strip off the PHP
     *
     * @param $command
     * @return string
     */
    protected static function fixupCommand($command)
    {
        $parts = explode(' ', $command);
        if (count($parts) > 2 && $parts[1] === "'artisan'") {
            array_shift($parts);
        }

        return implode(' ', $parts);
    }
}