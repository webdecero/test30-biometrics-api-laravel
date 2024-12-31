<?php
namespace App\Models;


use App\Enums\CompanySteps;
use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Casts\BoolCast;
use Webdecero\Package\Core\Casts\ImageObject;

class Company extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'isMultiLocation',
        'isGroupActive',
        'metadata',
        'status',
        'step',
        'isSync'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'key',
        'plesk',

        "managerDomain",
        "apiDomain",
        "notifyDomain",


        'mongoDB',
        'mysqlDB',

    ];

    protected $hidden = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'isGroupActive' => false,
        'isMultiLocation' => false,
        'status' => false,
        'metadata' => [],
    ];



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'isGroupActive' =>  BoolCast::class,
        'isMultiLocation' =>  BoolCast::class,
        'status' =>  BoolCast::class,
        'isSync' =>  BoolCast::class,
        'image' => ImageObject::class,
        'step' => CompanySteps::class
    ];



    // Childs

    public function locations() {
        return $this->hasMany(\App\Models\Location::class,'company_key', 'key');
    }
    public function registrys() {
        return $this->hasMany(\App\Models\Registry::class,'company_key', 'key');
    }

    public function kiosks() {
        return $this->hasMany(\App\Models\Kiosk::class,'company_key', 'key');
    }

    public function torniquets() {
        return $this->hasMany(\App\Models\Torniquet::class,'company_key', 'key');
    }

    public function recognitions() {
        return $this->hasMany(\App\Models\Recognition::class,'company_key', 'key');
    }

    public function groups() {
        return $this->hasMany(\App\Models\Group::class,'company_key', 'key');
    }

    public function users() {
        return $this->hasMany(\App\Models\User::class,'company_key', 'key');
    }


}
