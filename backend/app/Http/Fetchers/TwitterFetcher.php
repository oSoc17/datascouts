<?php namespace App\Http\Fetchers;

use App\Models\Handle;
use App\Models\Entity;
use App\Models\Provider;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterFetcher extends BaseFetcher
{
    
    private $connection;
    
    /**
     * Create a new controller instance
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
    
    protected function handle(Entity $entity)
    {
        $data = $this->connection->get("search/tweets", [
            "q" => $entity->name ." -filter:retweets",
            'result_type' => 'recent',   #['mixed', 'popular', 'recent']
            'count' => 100,
            'include_entities' => true
            
        ]);
        return array_map(array($this, 'filterData'), $data->statuses);
    }

    private function filterData($tweet)
    {
        $res = [
            'id' => $tweet->id_str,
            'created_at' => $tweet->created_at,
            'body' => $tweet->text,
            'user_full_name' => $tweet->user->name,
            'retweet_count' => $tweet->retweet_count,
            'favorite_count' => $tweet->favorite_count,
        ];
        $res['hastags'] = array_map(function ($hashtag) {
            return $hashtag->text;
        }, $tweet->entities->hashtags);
        
        $res['user'] = [
            'id' => $tweet->user->id_str,
            'screen_name' => $tweet->user->screen_name,
            'created_at' => $tweet->user->created_at,
            'friends_count' => $tweet->user->friends_count,
            'followers_count' => $tweet->user->followers_count,
            'statuses_count' => $tweet->user->statuses_count,
            'profile_image_url_https' => $tweet->user->profile_image_url_https,
        ];

        return $res;
    }
}
