<?php

namespace App\Models;

use App\Enums\AccessType;
use App\Enums\TerminalType;
use MongoDB\Laravel\Eloquent\Model;
use App\Http\Traits\ReflectionModel;
use Webdecero\Package\Core\Casts\KeyCast;
use Webdecero\Package\Core\Casts\BoolCast;

class Torniquet  extends Model
{
    use ReflectionModel;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'torniquet_terminals';

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

        'accessType',
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
        'accessType' => AccessType::class,
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'terminalType' => TerminalType::TORNIQUET,
        'accessType' => AccessType::IN,
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
}
