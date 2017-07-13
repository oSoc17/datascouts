<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Entity extends Model {
    
    use SoftDeletes;

    use UuidForKey;
    

    protected $primaryKey = 'uuid';

    public $incrementing = false;

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
    public $visible = ['name', 'url', 'image', "uuid", "user_uuid"];

    // Relationships



    public function creator()
    {
        return $this->belongsTo("App\Models\User",'user_uuid', 'uuid');
    }

    public function handles()
    {
        return $this->hasMany("App\Models\Handle", "entity_uuid", "uuid");
    }

}
