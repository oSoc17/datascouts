<?php namespace App\Http\Fetchers;

use App\Models\Handle;
use App\Models\Provider;

use Vimeo\Vimeo;

class VimeoFetcher extends BaseFetcher
{
    
    private $vimeoConnection;
    
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('vimeo');
        $this->vimeoConnection = new Vimeo(
            config('services.vimeo.client_id'),
            config('services.vimeo.client_secret'),
            config('services.vimeo.access_token')
        );
    }
    
    protected function handle(Handle $handle)
    {
        $response = $this->vimeoConnection->request('/videos', [
            'query' => urlencode($handle->name), 
            'direction' => 'DESC', // Show results in descending order
            'page' => 1,         // Show first page of results, 
            'per_page' => 100,   // Set the number of items to show to 100 (max)
            'sort' => 'relevant', // Sort by relevance
            // 'filter' => 'CC' // Filter only Creative Commons License videos
        ]);
        $body = array_shift($response);
        // var_dump($body['data']);
        return array_map(array($this, 'filterData'), $body['data']);
    }

    private function filterData($vimeo)
    {        
        $res = [
            'service_name' => $this->fetcherType,
            'id' => $vimeo['uri'],
            'title' => $vimeo['name'],
            'description' => $vimeo['description'],
            'link' => $vimeo['link'],
            'embed' => $vimeo['embed']['html'],
            'language' => $vimeo['language'],
            'created_at' => $vimeo['created_time'],
            'played_count' => $vimeo['stats']['plays'],
            'likes_count' => $vimeo['metadata']['connections']['likes']['total'],
            'comments_count' => $vimeo['metadata']['connections']['comments']['total'],
        ];

        $thumbnails  = $vimeo['pictures']['sizes'];
        $res['thumbnail'] = array_pop($thumbnails)['link_with_play_button'];

        $vimeoUser = $vimeo['user'];
        $avatars = $vimeoUser['pictures']['sizes'];
        $res['user'] = [
            'id' => $vimeoUser['uri'],
            'name' => $vimeoUser['name'],
            'description' => $vimeoUser['bio'],
            'from' => $vimeoUser['location'],   
            'since' => $vimeoUser['created_time'],
            'avatar' => (count($avatars) > 0  ? array_pop($avatars)['link'] : null ),
            'videos_count' => $vimeoUser['metadata']['connections']['videos']['total'],
            'likes_count' => $vimeoUser['metadata']['connections']['likes']['total'],
            'shared_count' => $vimeoUser['metadata']['connections']['shared']['total'],
            'followers_count' => $vimeoUser['metadata']['connections']['followers']['total'],
            'following_count' => $vimeoUser['metadata']['connections']['following']['total'],
        ];

        $collectKeywords = function ($tag) {
            return $tag['name'];
        };
        $res['keywords'] = array_map($collectKeywords, $vimeo['tags']);
        
        return $res;
    }


}
