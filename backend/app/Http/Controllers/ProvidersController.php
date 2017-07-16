<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

// use Laravel\Socialite\Contracts\Factory as Socialite; 
use Socialite;

use App\Models\Provider;
use App\Models\Service;
use App\Models\Handle;

class ProvidersController extends Controller
{
    use RESTActions;

    private $socialite;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Socialite $socialite)
    {
            $this->socialite = $socialite;
    }


    public function getLinkForLogin(Request $request, $handle)
    {
        $handle = Handle::where('id', $handle)
                            ->orWhere('url', strtolower($handle))
                            ->firstOrFail();

        // Get the service attached to this handle
        if(($service = $handle->service) == null){
            return this.respond(Response::HTTP_NOT_FOUND, 'This handle isn\'t attached to any service');
        }


        $link = $service->link;
        /*
            switch ($service) {
                case 'facebook':
                    $link = $link . '/v2.9/dialog/oauth?'; // Save this line in Db
                    $link .= 'client_id='.getenv('FACEBOOK_APP_ID');
                    $link .= '&redirect_uri='.getenv('FACEBOOK_APP_CALLBACK');
                break;
                
                case 'twitter':
                    $link = $link . '/v2.9/dialog/oauth?';
                    $link .= 'client_id='.getenv('FACEBOOK_APP_ID');
                    $link .= '&redirect_uri='.getenv('FACEBOOK_APP_CALLBACK');
                break;
                
                default:
                    break;
            }
        */
        $link = Socialite::with(strtolower($service->name))
                            ->stateless()
                            ->redirect()->getTargetUrl();
        
        return redirect($link.'&state='.$handle->url);
        // return $this->respond(Response::HTTP_OK, compact('link'));
    }

    public function handleCallback(Request $request, $service)
    {
        $handle = $request->input('state');
        $handleDb = Handle::where('url', $handle)->firstOrFail();
        

        $user = Socialite::with(strtolower($service))->stateless()->user();
        // Save this user with the oAuth code into Provider table

        // Create a JWT Token with the auth or provider created.
        dd($user);

        // Save the user info in Providers Table

        // Send HTTP_CREATED
    }

    public function fetch(Request $request){
        // Check for request.body[handles] 
        if(!$request->has('handles')){
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
                $handle->url => $handle->fetched()
            ];
        }

        return $this->respond(Response::HTTP_OK, $res);
    }
}
