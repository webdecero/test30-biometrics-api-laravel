<?php

namespace App\Http\Controllers\Registry\Profile;

use Webdecero\Manager\Api\Controllers\Admin\ProfileController as AdminProfileController;

class ProfileController extends AdminProfileController
{

    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('registry.profile.profile');
    }





}
