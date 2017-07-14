<?php namespace App\Http\Controllers;



class FacebookController extends Controller
{

    private $fb;

    public function __construct(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }


    public function login()
    {
        // Send an array of permissions to request
        $login_url = $this->fb->getLoginUrl(['email']);

        return $login_url;
    }

}
