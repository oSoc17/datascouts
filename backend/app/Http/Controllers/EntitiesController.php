<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Entity;
use App\Models\Handle;

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
        $handles = $entity->handles;

        if(is_null($handles)){
            $handles = [];
        }

        return $this->respond(Response::HTTP_OK, $handles);
    }

    public function addHandle(Request $request, $entity_uuid){
        $this->validate($request, Handle::$rules);

        $handleBody = $request->only(array_keys(Handle::$rules));
        $handle = new Handle($handleBody);
        $handle->uuid = Entity::generateUuid();

        $entity = Entity::findOrFail($entity_uuid);

        $handle->entity()->associate($entity);
        $handle->save();
        $entity->save();
        return $this->respond(Response::HTTP_OK, $handle);
    }


}
