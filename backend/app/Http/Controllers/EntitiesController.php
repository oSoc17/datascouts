<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;


class EntitiesController extends Controller {

    const MODEL = "App\Models\Entity";

    use RESTActions {
        RESTActions::add as traitRestAdd;
    }



    public function add(Request $request)
    {
        // Change the str_random for the real URL function
        $request->request->add(['url' => str_random(32)]);
        return $this->traitRestAdd($request);
    }

    // What happens to the handlers when delete a  entitty
    // CASCADE  or softDeletes ?


}
