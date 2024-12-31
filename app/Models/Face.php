<?php

namespace App\Models;

use Exception;
use App\Enums\SyncStatus;
use Illuminate\Support\Str;
use App\Enums\BiometricType;
use App\Enums\FaceTemplateFormat;
use App\Jobs\DeleteBiometricRecord;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Face  extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $fillable = [
        "userName",
        "templateFormat",

    ];
    protected $guarded = [
        'biometricType',
        "template",
        "image",
        'imageBinary',
        'templateBinary',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'imageBinary',
        'templateBinary',
    ];

    protected $casts = [
        'biometricType' => BiometricType::class,
        "templateFormat" => FaceTemplateFormat::class,
    ];

        /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'biometricType' => BiometricType::FACE,
        "templateFormat" => FaceTemplateFormat::FACENET512,
    ];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {

            $biometricsDisk = Storage::disk('biometrics');

            $prefixPath = $biometricsDisk->getConfig()['prefixPath'] ?? 'biometrics';

            $isDeleted = $biometricsDisk->delete(
                [
                    Str::after($model->image ?? '', $prefixPath . DIRECTORY_SEPARATOR),
                    Str::after($model->template ?? '', $prefixPath . DIRECTORY_SEPARATOR)
                ]
            );

            if (!$isDeleted)
                throw new Exception('Error al eliminar archivos, intente más tarde.');

            $model->biometricRecords()->whereIn('syncStatus',[ SyncStatus::PENDING, SyncStatus::ERROR])->delete();
            $model->biometricRecords()->where('syncStatus', SyncStatus::SYNCHRONIZED)->update(['syncStatus' => SyncStatus::DELETING]);
            $records = $model->biometricRecords()->get();

            dispatch(new DeleteBiometricRecord($records));
        });
    }





    // PARRENTS

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }



    // CHILDS

    public function biometricRecords()
    {
        return $this->hasMany(\App\Models\BiometricRecord::class);
    }


}
