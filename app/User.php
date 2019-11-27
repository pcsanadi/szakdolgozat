<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = "users";

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "email",
        "admin",
        "umpire_level",
        "referee_level"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "password",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    /**
     * The attributes that should be cast to native types
     */
    protected $casts = [
        "admin" => "boolean"
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        "umpireLevel",
        "refereeLevel"
    ];

    /**
     * Get the umpire level of this user
     */
    public function umpireLevel()
    {
        return $this->belongsTo("App\UmpireLevel", "umpire_level");
    }

    /**
     * Get the referee level of this user
     */
    public function refereeLevel()
    {
        return $this->belongsTo("App\RefereeLevel", "referee_level");
    }

    /**
     * Get the umpire applications of this user
     */
    public function umpireApplications()
    {
        return $this->hasMany("App\UmpireApplication", "umpire_id");
    }

    /**
     * Get the referee applications of this user
     */
    public function refereeApplications()
    {
        return $this->hasMany('App\RefereeApplication', 'referee_id');
    }
}
