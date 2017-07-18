<?php namespace App\Http\Fetchers;



use App\Models\Handle;
use App\Models\Entity;
use App\Models\Provider;

use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterFetcher extends BaseFetcher {
    
    private $connection;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {    
        parent::__construct('Twitter');
        $this->connection = new TwitterOAuth(
            config('abraham-twitteroauth.consumer_key'), 
            config('abraham-twitteroauth.consumer_secret'), 
            config('abraham-twitteroauth.access_token'), 
            config('abraham-twitteroauth.access_token_secret')
        );
    }
    

    protected function handle(Entity $entity) {
        $data = $this->connection->get("search/tweets", [
            "q" => $entity->name ." -filter:retweets",
            'result_type' => 'recent',   #['mixed', 'popular', 'recent']
            'count' => 1,
            'include_entities' => false
            
        ]);
        return $data->statuses;
    }

    //
}
