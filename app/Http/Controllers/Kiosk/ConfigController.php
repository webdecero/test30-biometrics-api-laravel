<?php
namespace App\Http\Controllers\Kiosk;



use Exception;
use ReflectionClass;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Enums\TerminalType;
use Illuminate\Support\Facades\Validator;
use App\Http\Utilities\BiometricsUtilities;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class ConfigController extends AbstractCoreController
{

    protected $version = null;
    protected $company = null;
    protected $prefixTerminal= 'kiosk';

    public function __construct()
    {
        // Cambiar por path de archivo configuración
        $this->initConfig("{$this->prefixTerminal}.config");
    }



    /**
     * Set configPath de archivo configuración
     * @param string $configPath
     * @param string $configPath
     */
    public function initConfig(String $configPath): string
    {

        $configPath = parent::initConfig($configPath);



        $this->version = config("{$this->prefixTerminal}.version");

        if (empty($this->version))
            throw new Exception('Not found config version terminal', 404);

        return $configPath;
    }



    function setup(Request $request)
    {

        try {


            $modelClass = $this->model;
            $model = new $modelClass();

            $input = $request->all();


            $validator = $this->validateByKey($input, __FUNCTION__);
            if (!empty($validator) && $validator->fails()) return $this->sendError('Error de validacion', $validator->errors()->all(), 422);


            $terminal = $model::where('key', $input['terminalKey'])->first();


            if (empty($terminal)) return $this->sendError('Not Found terminal', 'No se encontro terminal:' . $input['terminalKey'], 404);


            if (!$terminal->status) return $this->sendError('Terminal Status False', "La terminal {$terminal->name} se encuentra desactivada", 400);


            $company = $terminal->company;


            if (empty($company)) return $this->sendError('not_found_comany', 'No se encontro compañia', 404);


            if (!$company->status) return $this->sendError('status_false_company', "La compañia {$company->name} se encuentra desactivada", 400);



            if (!isset($terminal->deviceId) || $terminal->deviceId == null || empty($terminal->deviceId)) {

                $terminal->deviceId = $input['deviceId'];
                $terminal->save();
            } else if ($terminal->deviceId != $input['deviceId']) {

                return $this->sendError('DeviceId', 'Error deviceId: ' . $terminal->deviceId, 422);
            }


            $location = $terminal->location;

            if (empty($location)) throw new Exception('Not found location Record', 404);


            $version = config("{$this->prefixTerminal}.version");


            if (!isset($version[$input['version']]) || empty($version[$input['version']]))
                return $this->sendError('Not Found version', 'No se encontro version: ' . $input['version'], 404);

            $cf = $version[$input['version']];

            //TODO: configuración notifys

            $cf["company"] = [
                "key" => $company->key,
                "name" => $company->name,
                "isMultiLocation" => $company->isMultiLocation,
                "isGroupActive" => $company->isGroupActive,
                "status" => $company->status,
                "metadata" => $company->metadata
            ];

            $cf["location"] = [
                "key" => $location->key,
                "name" => $location->name,
                "metadata" => $location->metadata
            ];
            $cf["terminal"] = [
                "id" => $terminal->id,
                "key" => $terminal->key,
                "name" => $terminal->name,
                "status" => $terminal->status,
                "deviceId" => $terminal->deviceId,
                "metadata" => $terminal->metadata
                // "isSensorFingerprint" => $terminal->isSensorFingerprint,
                // "isSensorCamera" => $terminal->isSensorCamera,
                // "isServerNotify" => $terminal->isServerNotify,
            ];


            $cf["api"] = [
                "host" => url('/') . '/'
            ];



            return $this->sendResponse($cf, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }
}
