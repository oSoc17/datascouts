<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Handle;


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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Set to true $this->handle->isFetching
        // Set the fetched_at $this->handle = now();
        // Get all tweets, ....
        // Store them in DB.
        dd($this->handle->name);
 
    }
}
