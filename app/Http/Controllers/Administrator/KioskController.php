<?php
namespace App\Http\Controllers\Administrator;



use MongoDB\BSON\ObjectId;

use Exception;
use Illuminate\Http\Request;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class KioskController extends AbstractCoreController
{
    protected $debug = false;

    public function __construct(Request $request)
    {

        $this->debug = QueryUtilities::castValue($request->header('debug', 'false'));
        // Cambiar por path de archivo configuración
        $this->initConfig('administrator.kiosk');
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


            $record = $model::where('key', $input['key'])->first();


            if (!empty($record)) return $this->sendError('error_validation', "The registry has already been created.", 422);


            foreach ($input as $key => $data) {

                if ($key == 'id' && !empty($data) && preg_match('/^[a-f\d]{24}$/i', $data)) {
                    $data = new ObjectId($data);
                }

                $model->{$key} = $data;
            }

            $model->save();

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return  $this->debug?$this->sendError($th, __FUNCTION__)
                : $this->sendApiException($th, __FUNCTION__);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $model = $modelClass::find($id);

            $shortName = $this->reflectionClassModel->getShortName();
            $data = [];

            if (empty($model))
                throw new Exception($shortName . ' not found', 404);

            /**
             * TODO: hacer validaciones para borrado de terminal
             * no debe haber usuarios asociados
            */


            if (isset($this->config['destroy']['childs']) && !empty($this->config['destroy']['childs'])) {
                $childs = $this->config['destroy']['childs'];

                foreach ($childs as $key) {
                    $isExist = $this->reflectionClassModel->hasMethod($key);

                    if ($isExist) {
                        $data[$key] = (int) $model->$key()->delete();
                    } else {
                        $data[$key] = 'Not exist function ' . $key;
                    }
                }
            }

            $data[$shortName] = (int) $model->delete();
            return $this->sendResponse($data, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }


    /**
     * Reset resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request, $id)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $input = $request->all();

            $validator =  $this->validateByKey($input, __FUNCTION__);

            if (!empty($validator) && $validator->fails()) return $this->sendError('error_validation', $validator->errors()->all(), 422);

            $model = $modelClass::findOrFail($id);
            $model->modelName = $input['modelName'];
            $model->hostname = $input['hostname'];
            $model->deviceId = $input['deviceId'];
            $model->save();


            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }



}
