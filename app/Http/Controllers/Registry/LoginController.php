<?php


namespace App\Http\Controllers\Registry;

use Webdecero\Manager\Api\Controllers\Admin\Abstract\AbstractLoginController;

class LoginController extends AbstractLoginController
{


    public function __construct()
    {
        $this->initConfig('registry.profile.login');
    }


}
