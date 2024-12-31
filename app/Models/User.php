<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;
use App\Http\Services\CounterService;
use Illuminate\Notifications\Notifiable;
use Webdecero\Package\Core\Casts\IntCast;
use Webdecero\Package\Core\Casts\BoolCast;
use Webdecero\Manager\Api\Traits\HasScopes;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Webdecero\Manager\Api\Traits\TargetNotifications;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\contracts\InterfaceParentModelRelationable;

class User extends Authenticatable implements InterfaceParentModelRelationable
{

    use HasScopes, TargetNotifications;

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstName',
        'surname',
        'email',
        'avatar',
        'password',
        'status',
        'address',
        'phone',



        'metadata',
        'birthDate',
        'birthDateText',
        'age',
        'isAuthenticated',
        'isManual',
        'isPhoneVerified',
        'isEmailVerified',
        'isPasswordChanged',
        'backgroundColor',
    ];
    protected $guarded = [
        'terminalName',
        'terminalType',
        'recordId',


        'parentModelClass',
        'parentModelKey',
        'parentModelIndex',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => true,
        'metadata' => [],
        'isAuthenticated' => false,
        'firstName'=> '',
        'surname'=> '',
        'isManual' => false,
        'isPhoneVerified' => false,
        'isEmailVerified' => false,
        'isPasswordChanged' => false,
        'backgroundColor'=> '#61A5C2',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'avatar' => ImageObject::class,
        'recordId' => IntCast::class,
        'age' => IntCast::class,
        'status' => BoolCast::class,
        'email_verified_at' => 'datetime',
        'birthDate' => 'datetime',
        'isAuthenticated' => BoolCast::class,
        'isManual' => BoolCast::class,
        'isPhoneVerified' => BoolCast::class,
        'isEmailVerified' => BoolCast::class,
        'isPasswordChanged' => BoolCast::class,
    ];
    protected static function booted()
    {

        static::creating(function ($user) {
            // Asignar el próximo valor de la secuencia antes de crear el documento
            $user->recordId = CounterService::getNextSequence('users');

        });

        static::deleting(function ($user) {

            $fingerprints = $user->fingerprints()->get();
            foreach ($fingerprints as $fingerprint) {
                $fingerprint->delete();
            }

            $faces = $user->faces()->get();
            foreach ($faces as $face) {
                $face->delete();
            }

        });
    }





    //PARENTS


    public function relationParentModel(Model $related = null, $foreignKey = null, $otherKey = null)
    {
        $parentRelation = config('registry.user.parentRelation');
        $related = empty($related) ? $parentRelation['related'] : $related;
        $foreignKey = empty($foreignKey) ? $parentRelation['foreignKey'] : $foreignKey;
        $otherKey = empty($otherKey) ? $parentRelation['otherKey'] : $otherKey;

        return $this->belongsTo($related, $foreignKey, $otherKey);
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_key', 'key');
    }

    public function groups()
    {
        return $this->belongsToMany(\App\Models\Group::class, null, 'user_ids', 'group_keys', '_id', 'key');
    }

    public function locations()
    {
        return $this->belongsToMany(\App\Models\Location::class, null, 'user_ids', 'location_keys', '_id', 'key');
    }





    // CHILDS


    public function biometricRecords()
    {
        return $this->hasMany(\App\Models\BiometricRecord::class);
    }



    public function fingerprints()
    {
        return $this->hasMany(\App\Models\Fingerprint::class);
    }

    public function faces()
    {
        return $this->hasMany(\App\Models\Face::class);
    }

    public function access()
    {
        return $this->hasMany(\App\Models\Access::class);
    }


    public function attemps(): int
    {
        return $this->access()->count();
    }



}
