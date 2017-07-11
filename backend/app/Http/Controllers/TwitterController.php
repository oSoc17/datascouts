<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterController extends Controller {
    
    protected $connection;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->connection = new TwitterOAuth(
            config('abraham-twitteroauth.consumer_key'), 
            config('abraham-twitteroauth.consumer_secret'), 
            config('abraham-twitteroauth.access_token'), 
            config('abraham-twitteroauth.access_token_secret')
        );
    }
    
    
    public function show(Request $request, $q){
        $data = $this->connection->get("search/tweets", [
            "q" => $q ." -filter:retweets",
            'result_type' => 'mixed',   #['mixed', 'popular', 'recent']
            'count' => 7,
            'include_entities' => false
            
        ]);
        return response()->json(['data' => $data->statuses]);
    }

    //
}
