<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Handle;
use App\Http\Fetchers\TwitterFetcher;


class FetchController extends Controller
{
    use RESTActions;


    private $twitterFetcher;

    public function __construct(TwitterFetcher $twitterFetcher)
    {
        $this->twitterFetcher = $twitterFetcher;
    }


    public function getListOfHashtags(Request $request, $service)
    {
        

        $list = $twitterFetcher->getTrendsHashtags();

        dd($list);
    }


    public function fetch(Request $request)
    {
        // Check for request.body[handles]
        if (!$request->has('handles')) {
            return $this->respond(Response::HTTP_BAD_REQUEST, [
                'message' => 'Missing the handles in the request',
                "input" => $request->input()
            ]);
        }

        $requestHandles = $request->input('handles');
        $handles = Handle::listOfLastFetched($requestHandles)->get();

        $res = [];
        foreach ($handles as $handle) {
            $res[$handle->entity->url] = [
                $handle->url => $handle->fetched
            ];
        }

        return $this->respond(Response::HTTP_OK, $res);
    }
}
