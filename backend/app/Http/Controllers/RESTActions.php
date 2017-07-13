<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait RESTActions
{


    public function all()
    {
        $m = self::MODEL;
        return $this->respond(Response::HTTP_OK, $m::all());
    }

    public function get($uuid)
    {
        $m = self::MODEL;
        $model = $m::find($uuid);
        if (is_null($model)) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, $model);
    }

    public function add(Request $request)
    {
        $m = self::MODEL;
        $this->validate($request, $m::$rules);
        return $this->respond(Response::HTTP_CREATED, $m::create($request->all()));
    }

    public function put(Request $request, $uuid)
    {
        $m = self::MODEL;
        $this->validate($request, $m::$rules);
        $model = $m::find($uuid);
        if (is_null($model)) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $model->update($request->all());
        return $this->respond(Response::HTTP_OK, $model);
    }

    public function remove($uuid)
    {
        $m = self::MODEL;
        if (is_null($m::find($uuid))) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $m::destroy($uuid);
        return $this->respond(Response::HTTP_NO_CONTENT);
    }

    protected function respond($status, $data = [])
    {
        // if ($status == Response::HTTP_OK) {
            return response()->json($data, $status);
        // }
    }
}
