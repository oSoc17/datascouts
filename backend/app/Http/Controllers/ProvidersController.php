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

    const DELIMITER = '$$'; 

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
        // Check if send a URI to redirect to.
        if($request->has('redirect_uri')) {
            return $this->respond(Response::HTTP_BAD_REQUEST, [
                'message' => 'Missiing the redirect URI'
            ]);
        }

        $handle = Handle::where('id', $handle)
                            ->orWhere('url', strtolower($handle))
                            ->firstOrFail();

        // Get the service attached to this handle
        if(($service = $handle->service) == null){
            return $this->respond(Response::HTTP_NOT_FOUND, [
                'message' => 'This handle isn\'t attached to any service'
            ]);
        }

        // Retrieve the Target URL to the specific social media        
        $link = Socialite::with(strtolower($service->name))
                            ->stateless()
                            ->redirect()->getTargetUrl();
        
        // Add the redirect_uri into the state
        $redirectLink = '&state=' . $handle->url . DELIMITER;
        $redirectLink .= $request->input('redirect_uri');
        return redirect(urlencode($redirectLink));
    }

    public function handleCallback(Request $request, $service)
    {
        $state = explode(DELEIMITER,$request->input('state'));
        dd($state);
        // Explode the input(state)
        $handle = $state[0];
        $redirectURI = $state[1];

        $handleDb = Handle::where('url', $handle)->firstOrFail();
        
        // Retrieve the user via Socialite
        $providedUser = Socialite::with(strtolower($service))
                           ->stateless()
                           ->user();

        // Check if already got this provider
        $provider = Provider::where('social_id', $providedUser->id)->first();
        if(!$provided){
            // Create this proviser with the tokebn code into Provider table
            $provider = Provider::firstOrNew($providedUser);
            $provider->token = $providedUser->token;
            $provider->handle()->associate($handleDb);

            dd($providedUser, $provider);
        }

        // Create a JWT Token with the auth or provider created.

        // Save the user info in Providers Table
        $provider->save();

            // Send HTTP_CREATED with the token
        // return redirect($redirectURI.'&state='.$handle->url);
        
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
