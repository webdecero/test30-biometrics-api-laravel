<?php

namespace App\Http\Controllers\Manager;

use Exception;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class AccessRulesController extends AbstractCoreController
{
    public function __construct()
    {
        // Cambiar por path de archivo configuración
        $this->initConfig('manager.access-rules.config');
    }



    /**
     * Set configPath de archivo configuración
     * @param string $configPath
     * @param string $configPath
     */
    public function initConfig(String $configPath): string
    {
        $configPath = parent::initConfig($configPath);
        return $configPath;
    }

    public function validations()
    {
        try {

            //TODO: inicializar las variables locales
            $validations = config('manager.access-rules.validations');



            //TODO: validar que existe valitations
            foreach ($validations as $contextKey => $context) {
                if (!isset($context['rules'])) throw new Exception();


                foreach ($context['rules'] as $key => $rule) {


                    $operators = $this->_decodeOperators($rule['operators']);
                    $component = $this->_decodeComponents($rule['component']['key']);

                    if(isset($rule['component']['values'])) $component['values'] = $rule['component']['values'];
                    if(isset($rule['component']['placeholder'])) $component['placeholder'] = $rule['component']['placeholder'];

                    $response[] = [
                        'key' => "$contextKey.$key",
                        'model' => $context['model'],
                        'property' => $key,
                        'cast' => $rule['cast'],
                        'operators' => $operators,
                        'component' => $component,
                    ];
                }
            }

            return $this->sendResponse($response, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }

    private function _decodeOperators(array $operators): array
    {
        try {
            $operatorsConfig = config('manager.access-rules.operators');
            //TODO: validar que existe valitations
            $container = [];
            $response = [];

            foreach ($operators as $operator) {

                if (!isset($operatorsConfig[$operator->value])) throw new Exception();

                $container['key'] = $operator->value;
                $container['value'] = $operatorsConfig[$operator->value];
                $response[] = $container;
            }

            return $response;
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }

    private function _decodeComponents($component)
    {
        $componentsConfig = config('manager.access-rules.components');
        $container = [];
        $container['key'] = $component;
        $container = $componentsConfig[$component];

        return $container;
    }
}
