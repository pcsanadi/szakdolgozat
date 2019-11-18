<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefereeLevel extends Model
{
    /**
     * The table associated with the model
     * 
     * @var string 
     */
    protected $table = "referee_levels";

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
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that aren't mass assignable
     * 
     * @var array
     */
    protected $guarded = [
        "id",
        "level"
    ];

    /**
     * Get the users having this level
     */
    public function referees()
    {
        return $this->hasMany("App\User", "referee_level");
    }
}
