<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;

use App\Models\Handle;

use App\Http\Fetchers\VimeoFetcher;


class VimeoJob extends FetcherJob
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Handle $handle)
    {
        parent::__construct($handle, new VimeoFetcher);
    }

}
