<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Entity;
use App\Models\Handle;

class EntitiesController extends Controller {

    const MODEL = "App\Models\Entity";

    use RESTActions;


    public function getHandles($entity_id)
    {
        $handles = Entity::findOrFail($entity_id)->handles;


        if (is_null($handles)) {
            $handles = [];
        }

        return $this->respond(Response::HTTP_OK, $handles);
    }


    public function addHandle(Request $request, $entity_id)
    {
        $handleBody = $request->only(array_keys(Handle::$rules));
        $handle = new Handle($handleBody);

        $entity = Entity::findOrFail($entity_id);

        $handle->entity()->associate($entity);
        $handle->save();
        return $this->respond(Response::HTTP_OK, $handle);
    }

}
