<?php
namespace App\Http\Controllers\Registry\Profile;


use Webdecero\Manager\Api\Controllers\Admin\NotificationController as AdminNotificationController;

class NotificationController extends AdminNotificationController
{


    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('registry.profile.notification');
    }





}
