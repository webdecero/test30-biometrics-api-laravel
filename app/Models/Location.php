<?php

namespace App\Models;

use Illuminate\Support\Collection;
use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Casts\KeyCast;
use Webdecero\Package\Core\Casts\BoolCast;
use MongoDB\Laravel\Relations\BelongsToMany;

class Location extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "name",
        'status',
        "metadata"
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
        'status' => BoolCast::class,
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


    // Parents
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_key', 'key');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, null, 'location_keys', 'user_ids', 'key', '_id');
    }




    // Childs

    public function registrys()
    {
        return $this->hasMany(\App\Models\Registry::class, 'location_key', 'key');
    }

    public function kiosks()
    {
        return $this->hasMany(\App\Models\Kiosk::class, 'location_key', 'key');
    }

    public function torniquets()
    {
        return $this->hasMany(\App\Models\Torniquet::class, 'location_key', 'key');
    }

    public function recognitions()
    {
        return $this->hasMany(\App\Models\Recognition::class, 'location_key', 'key');
    }


}
