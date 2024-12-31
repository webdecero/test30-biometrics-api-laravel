<?php
namespace App\Enums;


enum BiometricType: string
{
    case FACE = 'face';
    case FINGERPRINT = 'fingerprint';
    case CARD = 'card';
    case PASSWORD = 'password';
}
