<?php

use App\Models\Registry;

return [
    'model' =>  Registry::class,
    'store' =>
    [
        'rules' => [
            'name' => ['required', 'string'],
            'status' => ['required'],
            'deviceId' => ['required', 'string'],
            'locationKey' => ['required', 'string'],
            'metadata' => ['sometimes', 'array'],
        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required', 'string'],
            'status' => ['required'],
            'deviceId' => ['required', 'string'],
            'locationKey' => ['required', 'string'],
            'metadata' => ['sometimes', 'array'],
        ],
        'autorize' => []


    ],
    'destroy' =>
    [
        'childs' => [],
        'autorize' => []


    ],
    'status' =>
    [
        'rules' => [
            'status' => ['required']
        ],
        'autorize' => []
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
                'key' => 'status',
                'operation' => '$eq'
            ],
            [
                'key'=> 'location_key',
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
                'key' => 'name',
                'header' => 'Nombre',
                'cast' => 'string'
            ],
            [
                'key' => 'key',
                'header' => 'Key',
                'cast' => 'string'
            ],
            [
                'key' => 'locationName',
                'header' => 'Locacion',
                'cast' => 'string'

            ],
            [
                'key' => 'type',
                'header' => 'Tipo',
                'cast' => 'string'

            ],
            [
                'key' => 'status',
                'header' => 'Estatus'

            ],
            [
                'key' => 'created_at',
                'header' => 'Fecha de Creación',
                'cast' => 'date'
            ]
        ]

    ],
];
