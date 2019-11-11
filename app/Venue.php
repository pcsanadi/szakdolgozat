<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'venues';

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
     * Get the users having this umpire level
     */
    // public function tournaments() // a umpire level can connect to many users
    // {
    //     return $this->hasMany('App\Tournament', 'venue_id');
    // }
}
