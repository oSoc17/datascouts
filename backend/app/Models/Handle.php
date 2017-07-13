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

    protected $visible = ["name", "url", "logo" , "uuid"];


    public function provider()
    {
        return $this->belongsTo("App\Models\Providers");
    }


}
