<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;

use App\Models\Handle;

use App\Http\Fetchers\TwitterFetcher;



class TwitterJob extends Job
{
    protected $handle;

    protected $twitterFetcher;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Handle $handle)
    {
        $this->handle = $handle;
        $this->twitterFetcher = new TwitterFetcher();
    }

    private function lockHandle(){
        // Now, lock this handle
        $this->handle->is_fetching = true;
        $this->handle->fetched_at = Carbon::now()->toDateTimeString();
        $this->handle->save();
    }

    private function unlock() {
        $this->handle->is_fetching = false;
        $this->handle->save();
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Act like a  Mutex
        $this->lockHandle();

        $this->twitterFetcher->fetch($this->handle);

        $this->unlock();
    }
}
