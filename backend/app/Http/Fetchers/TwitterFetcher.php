<?php namespace App\Http\Fetchers;

use App\Models\Handle;
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
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            config('services.twitter.access_token'),
            config('services.twitter.access_token_secret')
        );
    }
    
    protected function handle(Handle $handle)
    {
        $data = $this->connection->get("search/tweets", [
            "q" => $handle->name ." -filter:retweets",
            'result_type' => 'recent',   #['mixed', 'popular', 'recent']
            'count' => 100,
            'include_entities' => true
            
        ]);
        return array_map(array($this, 'filterData'), $data->statuses);
    }

    public function getTrendsHashtags(){
        $data =  $this->connection->get('trends/place', [
            'id' => '23424757'  # Belgium  or for brussels : 968019
        ]);

        return $data;
    }


    private function filterData($tweet)
    {
        $res = [
            'social_media' => 'twitter',
            'id' => $tweet->id_str,
            'created_at' => $tweet->created_at,
            'body' => $tweet->text,
            'link' => 'https://twitter.com/statuses/'.$tweet->id_str,
            'user_full_name' => $tweet->user->name,
            'retweet_count' => $tweet->retweet_count,
            'favorite_count' => $tweet->favorite_count,
        ];
        
        $res['user'] = [
            'id' => $tweet->user->id_str,
            'screen_name' => $tweet->user->screen_name,
            'since' => $tweet->user->created_at,
            'friends_count' => $tweet->user->friends_count,
            'followers_count' => $tweet->user->followers_count,
            'statuses_count' => $tweet->user->statuses_count,
            'profile_image_url_https' => $tweet->user->profile_image_url_https,
        ];
        
        if(isset($tweet->entities->hashtags)) {
            $res['hastags'] = array_map(function ($hashtag) {
                return $hashtag->text;
            }, $tweet->entities->hashtags);
        }
        
        if(isset($tweet->entities->media)) {
            $res['media'] = $tweet->entities->media[0]->media_url_https;
        }

        return $res;
    }
}
