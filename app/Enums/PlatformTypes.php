<?php
namespace App\Enums;

enum PlatformTypes: string
{

    case PLATFORM = 'platform';
    case MANAGER = 'manager';
    case REGISTRY = 'registry';
    case KIOSK = 'kiosk';
    case TORNIQUET = 'torniquet';



    public static function toArray()
    {
        $values = [];

        foreach (self::cases() as $props) {
            array_push($values, $props->value);
        }

        return $values;
    }
}
