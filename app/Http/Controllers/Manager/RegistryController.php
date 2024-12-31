<?php

namespace App\Http\Controllers\Manager;



use Exception;
use ReflectionClass;
use Illuminate\Http\Request;

use App\Http\Traits\CatalogCompany;
use App\Http\Traits\CatalogLocation;
use Webdecero\Package\Core\Exports\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\UTCDateTime;
use Webdecero\Package\Core\Controllers\Utilities\Cast;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;


class RegistryController extends AbstractCoreController
{
    use CatalogCompany;

    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('manager.registry');
    }





}
