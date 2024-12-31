<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Themes  extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'themes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "key",
        "type",
        "orderId",
        "serial",
        "file",
        "metadata"
        //company_key
        //location_key
        //terminal_key


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


    ];

            /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'metadata' => [],
    ];




}
