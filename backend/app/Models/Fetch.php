<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fetch extends Model {

    protected $fillable = ["data", "handle_id"];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];


    // Relationships

    public function handle()
    {
        return $this->belongsTo("App\Models\Handle");
    }


}
