<?php namespace App\Http\Fetchers;

use App\Models\Handle;
use App\Models\Provider;

use Madcoda\Youtube\Youtube as Ytb;

class YoutubeFetcher extends BaseFetcher
{
    
    private $ytbConnection;
    
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('Youtube');
        $this->ytbConnection = new Ytb([
            'key' => config('services.youtube.api_key')
        ]);
        
    }
    
    protected function handle(Handle $handle)
    {
        $data = $this->ytbConnection->searchAdvanced([
            'q'             => $handle->name,
            'type'          => 'channel,video,playlist',
            'part'          => 'id, snippet',
            'maxResults'    => 50
        ]);
        return array_map(array($this, 'filterData'), $data);
    }


    private function filterData($ytb)
    {
        $type = explode('#',$ytb->id->kind)[1];
        $res = [
            'service_name' => $this->fetcherType,
            'type' => $type,
            'id' => $ytb->id->{$type.'Id'},
            'title' => $ytb->snippet->title,
            'description' => $ytb->snippet->description,
            'thumbnail' => $ytb->snippet->thumbnails->medium->url,
            'channel' => $ytb->snippet->channelTitle
        ];
        
        $res['link'] = 'https://youtube.com/';
        $res['link'] .= (($type=='video') ? 'embed' : $type).'/'.$res['id'];
        
        return $res;
    }
}
