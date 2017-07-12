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

    public function get($id)
    {
        $m = self::MODEL;
        $model = $m::findOrFail($id);
        // if (is_null($model)) {
        //     return $this->respond(Response::HTTP_NOT_FOUND);
        // }
        return $this->respond(Response::HTTP_OK, $model);
    }

    public function add(Request $request)
    {
        $m = self::MODEL;
        $this->validate($request, $m::$rules);
        return $this->respond(
            Response::HTTP_CREATED, 
            $m::firstOrCreate($request->only(array_keys($m::$rules)))
        );
    }

    public function put(Request $request, $id)
    {
        $m = self::MODEL;
        $this->validate($request, $m::$rules);
        $model = $m::findOrFail($id);
        $keep = array_intersect_key($m::$rules,$request->all());
        // if (is_null($model)) {
        //     return $this->respond(Response::HTTP_NOT_FOUND);
        // }
        $model->update($request->only(\array_keys($keep)));
        return $this->respond(Response::HTTP_OK, $model);
    }

    public function remove($id)
    {
        $m = self::MODEL;
        $model = $m::findOrFail($id);
        // if (is_null($m::find($id))) {
        //     return $this->respond(Response::HTTP_NOT_FOUND);
        // }
        $model->destroy($id);
        return $this->respond(Response::HTTP_NO_CONTENT);
    }

    protected function respond($status, $data = [])
    {
        // dd($data);
        // if ($status == Response::HTTP_OK) {
            return response()->json(compact('data'), $status);
        // }
    }
}
