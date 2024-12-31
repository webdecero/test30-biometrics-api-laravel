<?php

namespace App\Http\Controllers\Manager;

use App\Http\Traits\CatalogCompany;
use Illuminate\Support\Facades\Auth;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;
use Webdecero\Manager\Api\Enums\NotificationStatus;

class UserController extends AbstractCoreController
{

    use CatalogCompany;

    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('manager.user');


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
        // $class = new ReflectionClass($this->model);
        // $instance = $class->newInstance();
        // if (!$instance instanceof InterfaceBioParentModelRelationable)
        //     throw new Exception('Model not instace of InterfaceBioParentModelRelationable', 400);


        return $configPath;
    }
    public function notifications()
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $user = Auth::user();
            if (empty($user))   return $this->sendError(__METHOD__, 'Usario no encontrado', 404);

            $notifications = $user->targetNotifications(PlatformTypes::PLATFORM)->where('isClicked',  false)->orderBy('created_at', 'desc')->get();

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
