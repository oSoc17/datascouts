<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handle extends Model {


    public $incrementing = false;

    protected $fillable = ["name", "url"];

    protected $dates = [];

    public static $rules = [
        "name" => "string|required|min:3",
        "url" => "string|unique:handles"
    ];


    protected $visible = [
        "id", "name", "url", "logo" , "color" ,
        "entity_id", 'provider_id', "service_id"
    ];


    public function provider()
    {
        return $this->belongsTo("App\Models\Provider");
    }


    public function entity()
    {
        return $this->belongsTo("App\Models\Entity");
    }

    public function service()
    {
        return $this->belongsTo("App\Models\Service");
    }

}
