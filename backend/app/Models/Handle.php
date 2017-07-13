<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handle extends Model {

    use UuidForKey;

    protected $primaryKey = "uuid";

    public $incrementing = false;

    protected $fillable = ["name", "url"];

    protected $dates = [];

    public static $rules = [
        "name" => "string|required|min:3",
        "url" => "string|unique:handles"
    ];


    protected $visible = [
        "name", "url", "logo" , "color" ,"uuid",
        "entity_uuid", 'provider_uuid', "service_uuid"];


    public function provider()
    {
        return $this->belongsTo("App\Models\Provider",'provider_uuid', 'uuid');
    }


    public function entity()
    {
        return $this->belongsTo("App\Models\Entity",'entity_uuid', 'uuid');
    }

    public function service()
    {
        return $this->belongsTo("App\Models\Service",'service_uuid', 'uuid');
    }

}
