<?php

namespace App\Models;

use App\Enums\TerminalType;
use MongoDB\Laravel\Eloquent\Model;
use App\Http\Traits\ReflectionModel;
use Webdecero\Package\Core\Casts\KeyCast;
use Webdecero\Package\Core\Casts\BoolCast;

class Kiosk  extends Model
{
    use ReflectionModel;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kiosk_terminals';

    protected $fillable = [
        // 'terminalType',
        // 'key',
        'name',
        'description',
        'status',
        'deviceId',
        'modelName',
        'brand',
        'features',
        'config',
        // 'company_key',
        'companyName',
        // 'location_key',
        'locationName',
        'metadata',

        'hostname',
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    protected $guarded = [
        'key',
        'terminalType',
    ];

    protected $casts = [
        'terminalType' => TerminalType::class,
        'key' => KeyCast::class,
        'status' => BoolCast::class,
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'terminalType' => TerminalType::KIOSK,
        'description' => null,
        'status' => true,
        'features' => [],
        'config' => [],
        'metadata' => [],
    ];

    // Parents

    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_key', 'key');
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_key', 'key');
    }



    // Chidls
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'terminal_key', 'key');
    }

    public function groups()
    {
        return $this->hasMany(\App\Models\Group::class, 'terminal_key', 'key');
    }
}
