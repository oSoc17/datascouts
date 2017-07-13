<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Service extends Model {
    
    use UuidForKey;

    protected $primaryKey = "uuid";

    public $incrementing = false;

    protected $fillable = ["name", "url", "logo"];

    protected $dates = [];

    public static $rules = [
        "name" => "string|unique:services|min:3",
        "url" => "string|unique:services",
        "logo" => "string",
    ];

    protected $visible = ["name", "url", "logo", "uuid"];


    // Eloquent determines the foreign key of the relationship based on the model name. 
    // In this case, the Handle model is automatically assumed to have a service_id FK. 
    // If you wish to override this convention, you may pass a second argument to the hasOne method:
    public function handle()
    {
        return $this->hasOne("App\Models\Handle", "social_media");
    }
    // Additionally, Eloquent assumes that the foreign key should have a value matching the id (or the custom $primaryKey) column of the parent. 
    // In other words, Eloquent will look for the value of the user's id column in the user_id column of the Phone record. 
    // If you would like the relationship to use a value other than id, you may pass a third argument to the 
    // hasOne method specifying your custom key:
    // return $this->hasOne('App\Phone', 'foreign_key', 'local_key');

    
    
    /**
     * Get the all providers related to this social media.
     */
    public function providers()
    {
        return $this->hasMany("App\Models\Providers" , 'provider_id', 'id');

    }

}
