<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = "tournaments";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "id";

    /**
     * Indicaes if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast to native types
     */
    protected $casts = [
        "requested_umpires" => "integer"
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        "venue"
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        "datefrom",
        "dateto"
    ];

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        "title",
        "datefrom",
        "dateto",
        "venue_id",
        "requested_umpires"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    /**
     * Get the venue of this tournament
     */
    public function venue()
    {
        return $this->belongsTo("App\Venue", "venue_id");
    }

    /**
     * Get the umpire applications for this tournament
     */
    public function umpireApplications()
    {
        return $this->hasMany("App\UmpireApplication", "tournament_id");
    }

    /**
     * Get the referee applications for this tournament
     */
    public function refereeApplications()
    {
        return $this->hasMany("App\RefereeApplication", "tournament_id");
    }

    /**
     * Check if the tournament will happen in the future
     *
     * @return boolean
     */
    public function isFuture()
    {
        return $this->datefrom->format("Ymd") >= date("Ymd");
    }
}
