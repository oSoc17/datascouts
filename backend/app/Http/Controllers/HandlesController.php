<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Handle;
use App\Models\Service;

class HandlesController extends Controller {

    const MODEL = "App\Models\Handle";

    use RESTActions;


    public function addService(Request $request, $handle_id, $service_id)
    {
        $handle = Handle::findOrFail($handle_id);
        $service = Service::findOrFail($service_id);
        $handle->service()->associate($service)->save();
        $handle->load('service');
        return $this->respond(Response::HTTP_OK,$handle);
    }

}
