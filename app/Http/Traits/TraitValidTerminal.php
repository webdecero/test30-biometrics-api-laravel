<?php
namespace App\Http\Traits;

use Exception;

use Illuminate\Http\Request;

trait TraitValidTerminal
{

    function valid(Request $request)
    {

        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;
            $model = new $modelClass();

            $input = $request->all();

            $validator = $this->validateByKey($input, __FUNCTION__);
            if (!empty($validator) && $validator->fails()) return $this->sendError('Error de validacion', $validator->errors()->all(), 422);

            $terminal  = $model::where('key', $input['terminalKey'])->where('deviceId', $input['deviceId'])->first();

            if (empty($terminal)) throw new Exception($input['terminalKey'].' Terminal not found', 404);


            $values = [
            "type",
            "status",
            "name",
            "key",
            "model"];
            $data = array_filter($terminal->toArray(), function($key) use ($values) {
                return in_array($key, $values);
            }, ARRAY_FILTER_USE_KEY);



            return $this->sendResponse($data, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }
}
