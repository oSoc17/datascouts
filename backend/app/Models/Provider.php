<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model {

    protected $fillable = [

    ];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['token'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    public $visible = [];





    // Relationships

    /**
     * Get the handle related to this provider.
     */
    public function handle()
    {
        return $this->hasOne("App\Models\Handle");
    }

    /**
     * Get the service related to this provider.
     */
    public function service()
    {
        return $this->belongsTo("App\Models\Service");
    }


}
