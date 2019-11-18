<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = "venues";

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
        "courts" => "integer"
    ];

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        "name",
        "short_name",
        "address",
        "courts"
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
     * Get the tournaments in this venue
     */
    public function tournaments()
    {
        return $this->hasMany("App\Tournament", "venue_id");
    }
}
