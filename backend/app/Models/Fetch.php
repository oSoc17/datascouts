<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Fetch extends Model
{
    // use BaseModel;

    protected $fillable = ["data", "handle_id", "medium_id"];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        
    ];

    public static $rules = [
        
    ];

    public $hidden = [ ];

    public $visible = [ ];


    // Local Scope


    

    // Accessors & Mutators


    // Relationships

    public function handle()
    {
        return $this->belongsTo("App\Models\Handle");
    }


}
