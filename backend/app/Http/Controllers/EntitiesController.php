<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class EntitiesController extends Controller {

    const MODEL = "App\Entity";

    use RESTActions;

    
    
    public function put(Request $request, $name)
    {
        $this->validate($request, \App\Entity::$rules);
        $entity = \App\Entity::where('name',$name);
        if (is_null($entity)) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $entity->update($request->all());
        return $this->respond(Response::HTTP_OK, $entity);
    }

    public function remove($name)
    {
        $entity = \App\Entity::where('name',$name);
        var_dump(is_null($entity));
        if (is_null($entity)) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $entity->delete();
        return $this->respond(Response::HTTP_NO_CONTENT);
    }




}
