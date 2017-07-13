<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handle extends Model {

    protected $primaryKey = "uuid";

    protected $fillable = ["name", "url"];

    protected $dates = [];

    public static $rules = [
        "name" => "string|required|min:3",
        "url" => "string|unique:handles"
    ];

    protected $visible = ["name", "url", "logo"];


    public function provider()
    {
        return $this->belongsTo("App\Models\Providers");
    }


}
