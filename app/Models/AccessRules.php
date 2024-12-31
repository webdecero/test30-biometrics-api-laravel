<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Traits\BooleanMutators;

use Webdecero\Package\Core\Casts\ImageObject;
use Webdecero\Package\Core\Casts\FileObject;

class AccessRules extends Model
{

    use BooleanMutators;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'access_rules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "status",
        "conext", //Enfocado a que configuracion
        "model", //modelo en el que se generaran las consultas
        "relation", //Relacion con el modelo Usuario
        "property", //Propiedad a evaluar
        "cast", //tipo de propiedad para hacer cast
        "operator", //funcion a ejecutar
        "value", //valor para evaluar
        "message" //Mensaje que se debe de regresar

    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $casts = [

        // 'quality' => 'integer',
        // 'width' => 'integer',
        // 'height' => 'integer',
        // 'size' => 'integer',
        // 'isPublic' => 'boolean'

    ];

}
