<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Entity extends Model {
    
    use BaseModel;


    protected $fillable = ["name", "url", "image"];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    public static $rules = [
        "name" => "string|unique:entities|min:3",
        "url" => "string|min:3",
        "image" => "string|min:3"
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [''];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    public $visible = [];


    // Relationships

    public function creator()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function handles()
    {
        return $this->hasMany("App\Models\Handle");
    }

}
