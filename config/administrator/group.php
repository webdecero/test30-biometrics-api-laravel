<?php

use Illuminate\Validation\Rule;
use App\Enums\TerminalType;


return [
    'model' =>  App\Models\Group::class,
    'store' =>
    [
        'rules' => [
            'title' => ['string'],
            'description' => ['string'],
            'address' => ['string'],
            'phone' => ['string'],
            'status' => ['required'],
            'metadata' => ['sometimes', 'array'],
            // 'terminalType' => ['required', Rule::enum(TerminalType::class)],
            // 'terminalKey' => ['required', 'string'],
            // 'locations' => ['required', 'array'],
            // 'parentModelIndex' => ['sometimes', 'string'],

        ],
        // 'autorize' => ['group-store']


    ],
    'update' =>
    [
        'rules' => [
            'title' => ['string'],
            'description' => ['string'],
            'address' => ['string'],
            'phone' => ['string'],
            'image' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'status' => ['sometimes'],
            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'locations' => ['required', 'array'],
            'metadata' => ['sometimes', 'array'],

            'parentModelIndex' => ['sometimes', 'string'],
        ],
        'autorize' => ['group-update']


    ],
    'destroy' =>
    [
        'childs' => [],
        'autorize' => ['group-delete']


    ],
    'status' =>
    [
        'rules' => [
            'status' => ['required']
        ],
        'autorize' => ['group-update']
    ],
    'search' =>
    [
        'except' => ['paginate', 'orderKey', 'orderBy', 'query', 'initDate', 'endDate'],
        'or' =>  [

            [
                'key' => 'name',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'locations',
                'operation' => '$in'
            ],
            [
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
