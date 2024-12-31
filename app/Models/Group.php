<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Casts\KeyCast;
use Webdecero\Package\Core\Casts\BoolCast;
use MongoDB\Laravel\Relations\BelongsToMany;
use Webdecero\Package\Core\Casts\ImageObject;
use App\Models\contracts\InterfaceParentModelRelationable;

class Group extends Model implements InterfaceParentModelRelationable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "title",
        "description",
        "address",
        "phone",
        "image",
        "status",
        "metadata"

    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = [
        "key",
        "parentModelClass",
        "parentModelKey",
        "parentModelIndex",
    ];


    protected $hidden = [];

    protected $casts = [

        'image' => ImageObject::class,
        'key' => KeyCast::class,
        'status' => BoolCast::class,

    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'metadata' => [],
        'status' => true,
    ];




    public function relationParentModel(Model $related = null, $foreignKey = null, $otherKey = null)
    {

        $parentRelation = config('registry.group.parentRelation');
        $related = empty($related) ? $parentRelation['related'] : $related;
        $foreignKey = empty($foreignKey) ? $parentRelation['foreignKey'] : $foreignKey;
        $otherKey = empty($otherKey) ? $parentRelation['otherKey'] : $otherKey;

        return $this->belongsTo($related, $foreignKey, $otherKey);
    }


    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_key', 'key');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, null, 'group_keys', 'user_ids', 'key', '_id');
    }


    //Childs



}
