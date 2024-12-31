<?php
namespace App\Enums;


enum SyncStatus: string
{
    case SYNCHRONIZED = 'synchronized';
    case PENDING = 'pending';
    case DELETING = 'deleting';
    case ERROR = 'error';
}
