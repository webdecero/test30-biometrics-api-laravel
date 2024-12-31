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
        'rules' => [
            'title' => ['string'],
            'description' => ['string'],
            'address' => ['string'],
            'phone' => ['string'],
            'image' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'status' => ['required'],

            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'locations' => ['required', 'array'],
            'metadata' => ['sometimes', 'array'],

            'parentModelIndex' => ['sometimes', 'string'],

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
            'terminalType' => ['sometimes', Rule::enum(TerminalType::class)],
            'terminalKey' => ['sometimes', 'string'],

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
                'header' => 'Titulo',
                'cast' => 'string'
            ],
            [
                'key' => 'description',
                'header' => 'Descripción',
                'cast' => 'string'
            ],
            [
                'key' => 'address',
                'header' => 'Dirección',
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

    ]
];
