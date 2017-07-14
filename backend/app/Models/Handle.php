<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handle extends Model
{



    protected $fillable = ["name", "url"];

    protected $dates = [];

    public static $rules = [
        "name" => "string|required|min:3",
        "url" => "string|unique:handles"
    ];

    public $hidden = [ ];

    public $visible = [ ];




    // Relationships

    public function entity()
    {
        return $this->belongsTo("App\Models\Entity");
    }

    public function service()
    {
        return $this->belongsTo("App\Models\Service");
    }

    public function provider()
    {
        return $this->belongsTo("App\Models\Provider");
    }
}
