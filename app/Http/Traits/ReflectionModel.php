<?php
namespace App\Http\Traits;

use Exception;
use ReflectionClass;


trait ReflectionModel
{

    /**
     * Get the short name of the model
     * param $model Model
     */
    public function getShortName(): string|null
    {
        try {
            return (new ReflectionClass($this))->getShortName();

        } catch (Exception $th) {
            return null;
        }
    }

    /**
     * Get the name of the model
     * param $model Model
     */
    public function getName(): string|null
    {
        try {
            return (new ReflectionClass($this))->getName();

        } catch (Exception $th) {
            return null;
        }
    }


}
