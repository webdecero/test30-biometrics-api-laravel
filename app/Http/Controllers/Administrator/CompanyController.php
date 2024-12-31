<?php

namespace App\Http\Controllers\Administrator;

use Exception;
use Illuminate\Http\Request;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

use MongoDB\BSON\ObjectId;

class CompanyController extends AbstractCoreController
{
    protected $debug = false;

    public function __construct(Request $request)
    {

        $this->debug = QueryUtilities::castValue($request->header('debug', 'false'));

        // Cambiar por path de archivo configuración
        $this->initConfig('administrator.company');
    }




    function store(Request $request)
    {

        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;
            $model = new $modelClass();

            $input = $request->all();

            $validator = $this->validateByKey($input, __FUNCTION__);
            if (!empty($validator) && $validator->fails()) return $this->sendError('error_validation', $validator->errors()->all(), 422);

            // Valide duplicate

            if (!empty($model::first())) return $this->sendError('error_validation', "The company has already been created.", 422);


            foreach ($input as $key => $data) {

                if ($key == 'id' && !empty($data) && preg_match('/^[a-f\d]{24}$/i', $data)) {
                    $data = new ObjectId($data);
                }

                $model->{$key} = $data;
            }

            //    return  $model;


            $model->save();

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return  $this->debug?$this->sendError($th, __FUNCTION__)
                : $this->sendApiException($th, __FUNCTION__);
        }
    }



}
