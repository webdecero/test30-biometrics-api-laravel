<?php
namespace App\Enums;


enum TerminalType: string
{
    case KIOSK = 'kiosk';
    case REGISTRY = 'registry';
    case TORNIQUET = 'torniquet';
    case RECOGNITION = 'recognition';
}
