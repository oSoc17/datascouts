<?php namespace App\Console\Commands;

use Illuminate\Support\Facades\Queue;
use Illuminate\Console\Command;

use App\Models\Handle;
use App\Jobs\TwitterJob;


class DataScoutsFetchHandles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datascouts:fetch-handlers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the social media data related to a specific handle';



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $handles = Handle::fetchable()->isOutDated()->get();

        foreach ($handles as $handle) {
            echo "Scheduler : Dispatch new Job for {$handle->service->name}\n";
            $job = new TwitterJob($handle);


            // if($handle->service->name  === 'Twitter'){
                dispatch($job->onQueue($handle->service->name));
            // }
        }
        
        
    }
}