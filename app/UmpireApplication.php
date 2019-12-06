<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UmpireApplication extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = "umpire_applications";

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
     *
     * @var array
     */
    protected $casts = [
        "processed" => "boolean",
        "approved" => "boolean"
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        "user",
        "tournament.venue"
    ];

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        "umpire_id",
        "tournament_id",
        "processed",
        "approved"
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
     * Get the user of this application
     */
    public function user()
    {
        return $this->belongsTo("App\User", "umpire_id")->withTrashed();
    }

    /**
     * Get the tournament of this application
    */
    public function tournament()
    {
        return $this->belongsTo("App\Tournament", "ournament_id")->withTrashed();
    }
}
