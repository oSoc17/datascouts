<?php namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\Handles;


class WatchSocialMediaHandle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datascouts:fetch-handlers
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the social media data related to a specific handle';


    protected $handles;

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
        $this->handles = Handles::all();

        foreach ($handles as $handle) {
            dd($handle);
        }
        
        
    }
}