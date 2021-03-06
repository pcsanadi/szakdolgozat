<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UmpireLevel extends Model
{
    /**
     * The table associated with the model
     * 
     * @var string 
     */
    protected $table = "umpire_levels";

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
    public $timestamps = false;

    /**
     * Get the users having this umpire level
     */
    public function umpires()
    {
        return $this->hasMany("App\User", "umpire_level");
    }
}
