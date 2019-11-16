<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UmpireApplication extends Model
{
    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'umpire_applications';

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
     * Get the user of this application
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'umpire_id');
    }

    /**
     * Get the tournament of this application
    */
    public function tournament()
    {
        return $this->belongsTo('App\Tournament', 'tournament_id');
    }
}
