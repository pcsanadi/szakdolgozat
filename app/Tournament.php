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
    protected $table = 'tournaments';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
     * Get the venue of this tournament
     */
    public function venue()
    {
        return $this->belongsTo('App\Venue', 'venue_id');
    }

    /**
     * Get the umpire applications for this tournament
     */
    public function umpireApplications()
    {
        return $this->hasMany('App\UmpireApplication', 'tournament_id');
    }
}
