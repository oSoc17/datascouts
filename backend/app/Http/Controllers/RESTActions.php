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
        return $this->respond(Response::HTTP_OK, $model);
    }

    public function getByURL($url)
    {
        $m = self::MODEL;
        $model = $m::where('url', $url)->firstOrFail();
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

        // Only keeps the inputs[key] matching with those specified in $rules
        $keep = array_intersect_key($m::$rules, $request->all());

        $model->update($request->only(array_keys($keep)));
        return $this->respond(Response::HTTP_OK, $model);
    }

    public function remove($id)
    {
        $m = self::MODEL;
        $model = $m::findOrFail($id);
        
        $model->destroy($id);
        return $this->respond(Response::HTTP_NO_CONTENT);
    }

    protected function respond($status, $data = [])
    {
        // dd($data);
        return response()->json($data, $status);
    }
}
