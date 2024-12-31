<?php

use App\Enums\FaceTemplateFormat;
use App\Enums\TerminalType;
use Illuminate\Validation\Rule;

return [
    'model' =>  \App\Models\Face::class,
    'store' =>
    [
        'rules' => [
            "userId" => ["required"],
            "image" => ['required', 'file'],
            "template" => ['required', 'file'],
            'templateFormat' => ['required', Rule::enum(FaceTemplateFormat::class)],
            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],
        ],
        'autorize' => []


    ],
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
