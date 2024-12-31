<?php

use Illuminate\Validation\Rule;
use App\Enums\TerminalType;

return [
    'model' =>  \App\Models\User::class,
    'matchFingerprint' =>
    [
        'rules' => [
            "templateFingerPrint" => ['required', 'file'],
            'terminalKey' => ['required', 'string'],
            'deviceId' => ['required', 'string'],
        ],
        'autorize' => []
    ],
];
