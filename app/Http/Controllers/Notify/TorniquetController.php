<?php
namespace App\Http\Controllers\Notify;




use App\Http\Traits\TraitValidTerminal;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class TorniquetController extends AbstractCoreController
{

    use TraitValidTerminal;


    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('notify.torniquet');


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


}
