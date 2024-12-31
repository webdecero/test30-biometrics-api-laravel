<?php

namespace App\Http\Controllers\Registry;



use Exception;
use ReflectionClass;
use App\Models\Themes;
use App\Models\Company;
use App\Enums\TerminalType;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Validator;
use App\Http\Utilities\BiometricsUtilities;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class ConfigController extends AbstractCoreController
{

    protected $version = null;
    protected $company = null;
    protected $prefixTerminal = TerminalType::REGISTRY->value;

    public function __construct()
    {
        // Cambiar por path de archivo configuración
        $this->initConfig("{$this->prefixTerminal}.config");
    }




    function setup(Request $request)
    {

        try {


            $modelClass = $this->model;
            $model = new $modelClass();

            $input = $request->all();


            $validator = $this->validateByKey($input, __FUNCTION__);
            if (!empty($validator) && $validator->fails())
                return $this->sendError('Error de validacion', $validator->errors()->all(), 422);


            $terminal = $model::where('key', $input['terminalKey'])->first();


            if (empty($terminal))
                return $this->sendError('Not Found terminal', 'No se encontro terminal:' . $input['terminalKey'], 404);


            if (!$terminal->status)
                return $this->sendError('Terminal Status False', "La terminal {$terminal->name} se encuentra desactivada", 400);


            $company = $terminal->company;


            if (empty($company))
                return $this->sendError('not_found_comany', 'No se encontro compañia', 404);


            if (!$company->status)
                return $this->sendError('status_false_company', "La compañia {$company->name} se encuentra desactivada", 400);



            if (!isset($terminal->deviceId) || $terminal->deviceId == null || empty($terminal->deviceId)) {

                $terminal->hostname = $input['hostname'] ?? '';
               $terminal->modelName = $input['modelName'] ?? '';
                $terminal->deviceId = $input['deviceId'];
                $terminal->save();
            } else if ($terminal->deviceId != $input['deviceId']) {

                return $this->sendError('DeviceId', 'Error deviceId: ' . $terminal->deviceId, 422);
            }


            $location = $terminal->location;

            if (empty($location))
                throw new Exception('Not found location Record', 404);


            $composerJson = (new Filesystem())->get(base_path('composer.json'));

            if (empty($composerJson))
                throw new Exception('Not found composer.json', 404);


            $composer = json_decode($composerJson, true);



            $cf = [
                "name" => "Terminal Biometrics Registry",
                "description" => "Terminal Biometric",
                "version" =>  (float)  str_replace('v', '', $composer['version'])
            ];

            $cf["company"] = [
                "key" => $company->key,
                "name" => $company->name,
                "isMultiLocation" => $company->isMultiLocation,
                "isGroupActive" => $company->isGroupActive,
                "status" => $company->status,
                "metadata" => $company->metadata
            ];

            $cf["api"] = [
                "host" => url('/') . '/'
            ];


            $notify = config("core.socketio.notify");
            $notify['url'] = rtrim($notify['url'], "/");

            if (strpos($notify['url'], 'http://') === false && strpos($notify['url'], 'https://') === false) {
                $notify['url'] = 'https://' . $notify['url'];
            }


            $cf["sockets"]["notify"] = [
                'url' => $notify['url'] . ':' . $notify['port'],
                'options' => $notify['options']
            ];


            $cf["location"] = [
                "key" => $location->key,
                "name" => $location->name,
                "status" => $company->status,
                "metadata" => $location->metadata
            ];
            $cf["terminal"] = [
                "id" => $terminal->id,
                "key" => $terminal->key,
                "name" => $terminal->name,
                "status" => $terminal->status,
                "deviceId" => $terminal->deviceId,
                "metadata" => $terminal->metadata
            ];







            return $this->sendResponse($cf, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }




    function theme(Request $request)
    {

        try {


            $modelClass = $this->model;
            $model = new $modelClass();

            $input = $request->all();


            $validator = $this->validateByKey($input, __FUNCTION__);
            if (!empty($validator) && $validator->fails())
                return $this->sendError('Error de validacion', $validator->errors()->all(), 422);


            // $terminal = $model::where('key', $input['terminalKey'])->first();


            // if (empty($terminal)) return $this->sendError('Not Found terminal', 'No se encontro terminal:' . $input['terminalKey'], 404);


            // if (!$terminal->status) return $this->sendError('Terminal Status False', "La terminal {$terminal->name} se encuentra desactivada", 400);


            // $company = $terminal->company;


            // if (empty($company)) return $this->sendError('not_found_comany', 'No se encontro compañia', 404);


            // if (!$company->status) return $this->sendError('status_false_company', "La compañia {$company->name} se encuentra desactivada", 400);

            $theme = Themes::where('type', 'registry')->first();




            $merge = array_merge($theme->default, $theme->custom);



            return $this->sendResponse($merge, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }

}
