<?php

return [
    'model' =>  \App\Models\Location::class,
    'store' =>
    [
        'rules' => [
            'key' => ['required','string'],
            'name' => ['required','string'],
            'status' => ['required'],
            'company_key' => ['required'],
            'metadata' => ['sometimes','array'],
        ],
        'autorize' => []

    ],
    'update' =>
    [
        'rules' => [
            'key' => ['required','string'],
            'name' => ['required','string'],
            'status' => ['required'],
            'company_key' => ['required'],
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
            ]
        ]


    ]
];
