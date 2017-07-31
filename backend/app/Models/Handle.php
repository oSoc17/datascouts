<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Handle extends Model
{
    // use BaseModel;

    protected $fillable = ["name", "url", "entity_id"];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fetched_at'
    ];

    public static $rules = [
        "name" => "string|min:3",
        "url" => "string|unique:handles"
    ];

    public $hidden = [ ];

    public $visible = [ ];


    // Local Scope

    // is Fetchable when is_Fetching === 0
    public function scopeFetchable($query)
    {
        return $query
                ->where('is_fetching', 0)
                ->whereNotNull('service_id');
    }

    // Check for the last fetch datetime in the last 5 min.
    public function scopeIsOutDated($query)
    {
        return $query->where('fetched_at', '<=', Carbon::now()->subMinute(5));
    }

    public function scopeListOfLastFetched($query, $list, $lastRequested = 0){
        return $query->whereNotNull('service_id')
                     ->whereIn('id', $list);
    }
    

    // Accessors & Mutators


    // Relationships

    public function entity()
    {
        return $this->belongsTo("App\Models\Entity");
    }

    public function service()
    {
        return $this->belongsTo("App\Models\Service");
    }

    public function fetched()
    {
        return $this->hasMany("App\Models\Feed");
    }
}
