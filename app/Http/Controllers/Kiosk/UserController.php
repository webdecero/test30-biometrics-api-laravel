<?php

namespace App\Http\Controllers\Kiosk;



use Exception;
use ReflectionClass;

use App\Models\Company;
use App\Models\Location;

use App\Enums\PlatformTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ParentRelationable;

use Illuminate\Support\Facades\Validator;
use App\Http\Utilities\BiometricsUtilities;
use Webdecero\Manager\Api\Enums\NotificationStatus;
use App\Http\Services\MatcherService\MatcherFingerService;
use App\Models\contracts\InterfaceParentModelRelationable;

use Webdecero\Manager\Api\Controllers\Admin\AdminController as AdminControllerParent;

class UserController extends AdminControllerParent
{

    use ParentRelationable;

    protected $company = null;



    public function __construct()
    {
        // Cambiar por path de archivo configuración
        $this->initConfig('kiosk.user');
    }



    /**
     * Set configPath de archivo configuración
     * @param string $configPath
     * @param string $configPath
     */
    public function initConfig(String $configPath): string
    {

        $configPath = parent::initConfig($configPath);
        // Ejemplo validaciones adicionaes
        $class = new ReflectionClass($this->model);
        $instance = $class->newInstance();
        if (!$instance instanceof InterfaceParentModelRelationable)
            throw new Exception($class->getShortName() . ' not instace of InterfaceParentModelRelationable', 400);



        return $configPath;
    }

    public function matchFingerprint(Request $request)
    {


        $this->validateScopes(__FUNCTION__);

        $input = $request->all();
        // Obtener y validar el input

        $validator = $this->validateByKey($input, __FUNCTION__);

        if (!empty($validator) && $validator->fails()) {
            return $this->sendError('Error de validación', $validator->errors()->all(), 422);
        }

        $company = Company::first();
        $terminal =  BiometricsUtilities::getTerminalByType($input['terminalKey'], 'torniquet');
        $location = Location::where('key', $terminal->location_key)->first();

        if (empty($location)) return $this->sendError('Not Found terminal', 'No se encontro la locacion:' . $terminal->location_key, 404);
        if (empty($terminal)) return $this->sendError('Not Found terminal', 'No se encontro la terminal:' . $input['terminalKey'], 404);

        if (!$company->status) return $this->sendError('status_false_company', "La compañia {$company->name} se encuentra desactivada", 400);
        if (!$location->status) return $this->sendError('status_false_location', "La locacion {$location->name} se encuentra desactivada", 400);
        if (!$terminal->status)  return $this->sendError('status_false_terminal', "La terminal {$terminal->name} se encuentra desactivada", 400);

        $matcherservice = new MatcherFingerService($company->key, 'Users');
        $response = $matcherservice->matcher($input['templateFingerPrint']);

        //Validar la respuesta
        if (!$response['success']) return $response;

        $subjectId = $response['data']['subjects'][0]['subjectId'];

        $user = $this->model::where('_id', $subjectId)->first();

        if (!isset($user)) return $this->sendError('Subject not found', 'Subject not found in MongoDB', 422);
        return $this->sendResponse($user);
    }


    public function notifications()
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $user = Auth::user();
            if (empty($user))   return $this->sendError(__METHOD__, 'Usario no encontrado', 404);

            $notifications = $user->targetNotifications([PlatformTypes::KIOSK, '*'])->where('isClicked',  false)->orderBy('created_at', 'desc')->get();

            foreach ($notifications as $notification) {

                $notification->status = NotificationStatus::DONE;
                $notification->save();
            }



            return $this->sendResponse($notifications, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __METHOD__);
        }
    }
}
