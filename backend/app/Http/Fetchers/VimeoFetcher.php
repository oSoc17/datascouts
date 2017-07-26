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
        parent::__construct('Vimeo');
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
            'per_page' => 1,   // Set the number of items to show on each page to 50
            'sort' => 'relevant', // Sort by relevance
            'filter' => 'CC' // Filter only Creative Commons License videos
        ]);
        var_dump(array_keys($response));
        // return array_map(array($this, 'filterData'), $data);
    }


    private function filterData($ytb)
    {
        $type = explode('#', $ytb->id->kind)[1];
        $res = [
            'service_name' => $this->fetcherType,
            'type' => $type,
            'id' => $ytb->id->{$type.'Id'},
            'title' => $ytb->snippet->title,
            'description' => $ytb->snippet->description,
            'thumbnail' => $ytb->snippet->thumbnails->medium->url,
            'channel' => $ytb->snippet->channelTitle
        ];
        
        $res['link'] = 'https://vimeo.com/';
        $res['link'] .= (($type=='video') ? 'embed' : $type).'/'.$res['id'];
        
        return $res;
    }
}
