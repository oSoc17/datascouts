<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;

use App\Models\Handle;

// use Abraham\TwitterOAuth\TwitterOAuth;



class TwitterJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    private $handle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Handle $handle)
    {
        $this->handle = $handle;
        print_r("New Twitter Job : Added\n");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Now, lock this handle
        $this->handle->is_fetching = true;
        $this->handle->fetched_at = Carbon::now()->toDateTimeString();

        $this->handle->save();
        // $data = $this->connection->get("search/tweets", [
        //     "q" => $q ." -filter:retweets",
        //     'result_type' => 'mixed',   #['mixed', 'popular', 'recent']
        //     'count' => 7,
        //     'include_entities' => false
            
        // ]);

        // Store them in DB.

        $this->handle->is_fetching = false;

    }
}
