<?php

use Illuminate\Validation\Rule;
use App\Enums\TerminalType;

return [
    'model' =>  \App\Models\User::class,
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'string'],
            'avatar' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'status' => ['required'],
            'address' => ['nullable', 'string'],
            'phone' => ['sometimes', 'string'],

            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'groupKeys' => ['required', 'array'],
            'locationKeys' => ['required', 'array'],

            'metadata' => ['sometimes', 'array'],
            'parentModelIndex' => ['sometimes', 'string'],
        ],


    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'string'],
            'avatar' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'status' => ['sometimes', 'string'],
            'address' => ['nullable', 'string'],
            'phone' => ['sometimes', 'string'],

            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'groupKeys' => ['required', 'array'],
            'locationKeys' => ['required', 'array'],

            'metadata' => ['sometimes', 'array'],
            'parentModelIndex' => ['sometimes', 'string'],
        ],
        'autorize' => []


    ],
    'destroy' =>
    [

        //Funcion del modelo que borra en Cascada
        'childs' => ['fingerprints', 'faces'],
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
            ],
            [
                'key' => 'email',
                'options' => 'i'

            ],
            [
                'key' => 'phone',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'location_keys',
                'operation' => '$in'
            ],
            [
                'key' => 'group_keys',
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
                'key' => 'name',
                'header' => 'Nombre',
                'cast' => 'string'
            ],
            [
                'key' => 'email',
                'header' => 'Correo electronico',
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
                'key' => 'address',
                'header' => 'Direccion',
                'cast' => 'string'
            ],
            [
                'key' => 'status',
                'header' => 'Estatus',
                'cast' => 'string'

            ],
            [
                'key' => 'terminalName',
                'header' => 'Terminal',
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
