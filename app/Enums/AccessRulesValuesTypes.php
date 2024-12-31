<?php
namespace App\Enums;


enum AccessRulesValuesTypes: string
{
    case INT = 'int';
    case FLOAT = 'float';
    case STRING = 'string';
    case BOOLEAN = 'boolean';
    case DATE = 'date';
    case ARRAY = 'array';
    case FUNCTION = 'function';


    function casts($variable) {
        switch ($variable) {
            case self::BOOLEAN:
                # code...
                break;

            default:
                # code...
                break;
        }
    }
}
