<?php

namespace App\Models;

use App\Enums\SyncStatus;
use App\Enums\TerminalType;
use App\Enums\BiometricType;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class BiometricRecord extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'biometric_records';


    protected $fillable = [
        'userName',
        'userRecordId',
        'terminalName',
        'companyName',
        'locationName',
        'syncStatus',
        'biometricType',
        'created_at',


    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'imageBinary',
        'templateBinary',
        'responseRecogniton',
    ];

    protected $guarded = [
        'terminalType',
    ];

    protected $casts = [
        'biometricType' => BiometricType::class,
        'terminalType' => TerminalType::class,
        'syncStatus' => SyncStatus::class,
        'created_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'terminalType' => TerminalType::RECOGNITION,
        'syncStatus' => SyncStatus::PENDING,
    ];

    // Parents
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_key', 'key');
    }
    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_key', 'key');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function fingerprint()
    {
        return $this->belongsTo(\App\Models\Fingerprint::class);
    }

    public function face()
    {
        return $this->belongsTo(\App\Models\Face::class);
    }


    public function terminal()
    {
        switch ($this->terminalType) {
            case TerminalType::RECOGNITION:
                return $this->belongsTo(\App\Models\Recognition::class, 'terminal_key', 'key');
            case TerminalType::TORNIQUET:
                return $this->belongsTo(\App\Models\Torniquet::class, 'terminal_key', 'key');
            case TerminalType::KIOSK:
                return $this->belongsTo(\App\Models\Kiosk::class, 'terminal_key', 'key');
            case TerminalType::REGISTRY:
                return $this->belongsTo(\App\Models\Registry::class, 'terminal_key', 'key');
            default:
                throw new \Exception("Unsupported terminal type: " . $this->terminalType->value);
        }
    }

    public function biometric(): BelongsTo
    {
        //TODO: agregar mas tipos de biometricos
        switch ($this->biometricType) {

            case BiometricType::FINGERPRINT:
                return $this->belongsTo(\App\Models\Fingerprint::class, 'fingerprint_id', 'id');
            case BiometricType::FACE:
                return $this->belongsTo(\App\Models\Face::class, 'face_id', 'id');
            default:
                throw new \Exception("Unsupported biometric type: " . $this->biometricType->value);
        }
    }


    // Chidls
}
