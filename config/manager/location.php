<?php

return [
    'model' =>  \App\Models\Location::class,
    'store' =>
    [
        'rules' => [
            'name' => ['required', 'string',],
            'metadata' => ['sometimes','array'],
        ],
        'autorize' => []

    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required', 'string'],
            'metadata' => ['sometimes','array'],
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
        'except' =>['paginate', 'orderKey', 'orderBy', 'query', 'initDate', 'endDate'],
        'or' =>  [

            [
                'key' => 'name',
                'options' => 'i'
            ]
        ],
        'and' =>  [
            [
                'key' => 'key',
                'operation' => '$eq'
            ],
            [
                'key' => 'status',
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
                'key' => 'key',
                'header' => 'Clave',
                'cast' => 'string'
            ],
            [
                'key' => 'name',
                'header' => 'Nombre',
                'cast' => 'string'
            ],
            [
                'key' => 'status',
                'header' => 'Estatus',
                'cast' => 'boolean'

            ],
            [
                'key' => 'created_at',
                'header' => 'Fecha de Creación',
                'cast' => 'date'
            ]
        ]
    ],
];
