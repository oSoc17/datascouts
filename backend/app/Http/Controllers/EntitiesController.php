<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Entity;

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

    public function getHandles(Entity $entity){
        $entityHandles = $entity->handle;
        if(is_null($entity->handle)){
            $entityHandles = [];
        }
        return $this->respond(Response::HTTP_OK, $entityHandles);
    }


}
