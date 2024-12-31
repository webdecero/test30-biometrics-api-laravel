<?php

use Webdecero\Manager\Api\Models\Notification;


return [
    'model' =>  Notification::class,
    'store' =>
    [
        'rules' => [
            'title' => ['sometimes','string'],
            'description' => ['sometimes','string'],
            'image' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage ],
            'priority' => ['sometimes','string'],
            'uri' => ['sotimes','string'],
            'payload'=>['sometimes','array'],
            'originId'=>['sometimes','string'],
            'originModel'=>['sometimes','string'],
        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            'title' => ['sometimes','string'],
            'description' => ['sometimes','string'],
            'image' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage ],
            'priority' => ['sometimes','string'],
            'uri' => ['sotimes','string'],
            'payload'=>['sometimes','array'],
            'originId'=>['sometimes','string'],
            'originModel'=>['sometimes','string'],
        ],
        'autorize' => []


    ],
    'destroy' =>
    [
        'childs' => [
        ],
        'autorize' => []


    ],
    'search' =>
    [
        'except' =>['paginate', 'orderKey', 'orderBy', 'query', 'initDate', 'endDate','format'],
        'or' =>  [

            [
                'key' => 'title',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'priority',
                'operation' => '$eq'
            ],
            [
                'key' => 'originId',
                'operation' => '$eq'
            ]
        ]
    ],
    'export' =>
    [
        'autorize' => [],
        'columns' =>  [
            [
                'key' => '_id',
                'header' => 'ID',
                'cast' => 'string'
            ],
            [
                'key' => 'title',
                'header' => 'Título',
                'cast' => 'string'
            ],
            [
                'key' => 'description',
                'header' => 'Descripción',
                'cast' => 'string'
            ],
            [
                'key' => 'priority',
                'header' => 'ID',
                'cast' => 'string'
            ],
            [
                'key' => 'uri',
                'header' => 'URI',
                'cast' => 'string'
            ],
            [
                'key' => 'payload',
                'header' => 'Payload',
                'cast' => 'string'
            ],
            [
                'key' => 'originId',
                'header' => 'ID de origen',
                'cast' => 'string'
            ],
            [
                'key' => 'created_at',
                'header' => 'Fecha de Creación',
                'cast' => 'date'
            ]
        ]
    ]
];
