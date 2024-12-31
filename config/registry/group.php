<?php

use Illuminate\Validation\Rule;
use App\Enums\TerminalType;


return [
    'model' =>  App\Models\Group::class,
    'parentRelation' =>
    [
        //Modelo relacion de parent a user, parentModel
        'related' =>  App\Models\Test::class,
        //Llave foranea en User para la relación
        'foreignKey' => 'parentModelIndex',
        //indice de referencia en parent Model para busqueda| parentModelIndex
        'otherKey' => 'key'
    ],
    'store' =>
    [
        'autorize' => [],
        'rules' => [
            'title' => ['string'],
            'description' => ['string'],
            'address' => ['string'],
            'phone' => ['string'],
            'image' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'status' => ['required'],

            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],
            'metadata' => ['sometimes', 'array'],

            'parentModelIndex' => ['sometimes', 'string'],
        ],


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
            'metadata' => ['sometimes', 'array'],

            'parentModelIndex' => ['sometimes', 'string'],
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
                'key' => 'title',
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
                'key' => 'address',
                'header' => 'Direccion',
                'cast' => 'string'
            ],
            [
                'key' => 'phone',
                'header' => 'Telefono',
                'cast' => 'string'
            ],
            [
                'key' => 'status',
                'header' => 'Estatus',
                'cast' => 'string'

            ],
            [
                'key' => 'locations',
                'header' => 'Sucursales',
                'cast' => 'string'

            ],
            [
                'key' => 'created_at',
                'header' => 'Fecha de registro',
                'cast' => 'date'
            ]
        ]

    ],
];
