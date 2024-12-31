<?php

return [
    'model' =>  App\Models\AccessRules::class,
    'store' =>
    [
        'rules' => [
            "conext"=> ['required', 'string',],
            "model"=> ['required', 'string',],
            "relation" => ['required', 'string',],
            "property" => ['required', 'string',],
            "propertyType" => ['required', 'string',],
            "operator" => ['required', 'string',],
            "value" => ['required', 'string',],
            "message" => ['required', 'string',],
        ],
        'autorize' => []

    ],
    'update' =>
    [
        'rules' => [
            "conext"=> ['required', 'string',],
            "model"=> ['required', 'string',],
            "relation" => ['required', 'string',],
            "property" => ['required', 'string',],
            "propertyType" => ['required', 'string',],
            "operator" => ['required', 'string',],
            "value" => ['required', 'string',],
            "message" => ['required', 'string',],
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
        'autorize' => [],
        'except' =>['paginate', 'orderKey', 'orderBy', 'query', 'initDate', 'endDate'],
        'or' =>  [

            [
                'key' => 'name',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'metadata.location',
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
                'key' => 'name',
                'header' => 'Nombre',
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
