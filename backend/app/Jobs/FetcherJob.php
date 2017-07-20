<?php namespace App\Jobs;

use Carbon\Carbon;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class FetcherJob extends Job
{
    
    protected $handle;
    
    protected $fetcher;
    
    
    protected function  __construct($handle, $fetcher){
        $this->handle = $handle;
        
        $this->fetcher = $fetcher;
    }


    protected function lockHandle(){
        // Now, lock this handle
        $this->handle->is_fetching = true;
        $this->handle->fetched_at = Carbon::now()->toDateTimeString();
        $this->handle->save();
    }

    protected function unlock() {
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

        $this->fetcher->fetch($this->handle);

        $this->unlock();
    }



}
