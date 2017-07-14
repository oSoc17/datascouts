<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Service extends Model {
    
    // use SoftDeletes;

    protected $fillable = ["name", "link", "logo","color"];

    protected $dates = [];

    public static $rules = [
        "name" => "string|unique:services|min:3",
        "link" => "string|unique:services",
        "logo" => "string",
    ];

    public $visible = ["id","name", "link", "logo",  "color"];



    // Relationships


    // Eloquent determines the foreign key of the relationship based on the model name. 
    // In this case, the Handle model is automatically assumed to have a service_id FK. 
    // If you wish to override this convention, you may pass a second argument to the hasOne method:
    public function handle()
    {
        return $this->hasMany("App\Models\Handle");
    }
    // Additionally, Eloquent assumes that the foreign key should have a value matching the id (or the custom $primaryKey) column of the parent. 
    // In other words, Eloquent will look for the value of the user's id column in the user_id column of the Phone record. 
    // If you would like the relationship to use a value other than id, you may pass a third argument to the 
    // hasOne method specifying your custom key:
    // return $this->belongsTo('App\Phone', 'foreign_key', 'local_key');

    
    /**
     * Get the all providers related to this social media.
     */
    public function providers()
    {
        return $this->hasMany("App\Models\Provider");

    }

}
