<?php

use App\Enums\FingerTemplateFormat;
use App\Enums\HandTypes;
use App\Enums\FingerTypes;
use App\Enums\TerminalType;
use Illuminate\Validation\Rule;

return [
    'model' =>  \App\Models\Fingerprint::class,
    'store' =>
    [
        'rules' => [
            "userId" => ["required"],
            "typeFinger" => ["required", Rule::enum(FingerTypes::class)],
            "typeHand" => ["required", Rule::enum(HandTypes::class)],
            "image" => ['required', 'file'],
            "template" => ['required', 'file'],
            'templateFormat' => ['required', Rule::enum(FingerTemplateFormat::class)],
            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],
        ],
        'autorize' => []


    ],
    // 'update' =>
    // [
    //     'rules' => [
    //         "userId" => ["required"],
    //         "typeFinger" => ["required", Rule::enum(FingerTypes::class)],
    //         "typeHand" => ["required", Rule::enum(HandTypes::class)],
    //         "pathImageFingerPrint" => ['required', 'file'],
    //         "pathTemplateFingerPrint" => ['required', 'file'],
    //         'terminalType' => ['required', Rule::enum(TerminalType::class)],
    //         'terminalKey' => ['required', 'string'],

    //         'metadata' => ['sometimes', 'array'],
    //     ],
    //     'autorize' => []


    // ],
    'destroy' =>
    [
        'childs' => [],
        'autorize' => []
    ],
    'search' =>
    [
        'except' => ['paginate', 'orderKey', 'orderBy', 'query', 'initDate', 'endDate'],
        'or' =>  [

            [
                'key' => 'locationName',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'location_key',
                'operation' => '$eq'
            ],
            [
                'key' => 'terminal_key',
                'operation' => '$eq'
            ],
            [
                'key' => 'user_id',
                'operation' => '$eq'
            ]
        ]


    ]
];
