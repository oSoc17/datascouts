<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Provider extends Model {
    
    // use SoftDeletes;

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
    ];

    public $visible = [];



    // Relationships

    /**
     * Get the handle related to this provider.
     */
    public function handle()
    {
        return $this->belongs("App\Models\Handle");
    }
    
    /**
     * Get the service related to this provider.
     */
    public function service()
    {
        return $this->belongsTo("App\Models\Service");
    }

}
