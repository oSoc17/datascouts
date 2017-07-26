<?php namespace App\Console\Commands;

use Illuminate\Support\Facades\Queue;
use Illuminate\Console\Command;

use App\Models\Handle;
use App\Jobs\ExampleJob;
use App\Jobs\TwitterJob;
use App\Jobs\VimeoJob;
use App\Jobs\YoutubeJob;


class DataScoutsFetchHandles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datascouts:fetch-handles {--only= : Only for this handle}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the social media data related to a specific handle';


    private $queueName = 'fetchers';

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
        if($this->option('only')) {
            $handles = [Handle::findOrFail(intval($this->option('only')))];
        }else{
            $handles = Handle::fetchable()->isOutDated()->get();
            // $handles = Handle::all();
        }
        
        foreach ($handles as $handle) {
            // echo "Scheduler : Dispatch new Job for {$handle->service->name}\n";
            $fetcherJob = null;

            switch (strtolower($handle->service->name)) {
                case 'twitter':
                    $fetcherJob = new TwitterJob($handle);
                    break;

                case 'vimeo':
                     $fetcherJob = new VimeoJob($handle);
                    break;
                    
                case 'youtube' :
                    $fetcherJob = new YoutubeJob($handle);
                    break;
                
                default:
                    $fetcherJob = null;
                    break;
            }
            // Push into the fetchers queue
            if($fetcherJob){
                dispatch($fetcherJob->onQueue($this->queueName));
            }
        }
        
        
    }
}