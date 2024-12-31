<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Casts\KeyCast;
use Webdecero\Package\Core\Casts\BoolCast;

class Test  extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'test';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "name",
        "status",
        "deviceId",
        "metadata",
        "locationName"

    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $guarded = [
        "key"
    ];

    protected $casts = [
        'key' => KeyCast::class,
        'status' => BoolCast::class
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => true,
        'metadata' => [],
    ];

}
