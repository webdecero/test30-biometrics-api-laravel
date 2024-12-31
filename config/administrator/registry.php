<?php

return [
    'model' =>  \App\Models\Registry::class,
    'store' =>
    [
        'rules' => [
            'key' => ['required','string'],
            'terminalType' => ['required'],
            'name' => ['required','string'],
            'status' => ['required'],
            'metadata' => ['sometimes','array'],
            'location_key' => ['required'],
            'locationName' => ['required'],
            'company_key' => ['required'],
            'companyName' => ['required']
        ],
        'autorize' => []

    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required','string'],
            'description' => ['nullable','string'],
            'status' => ['required'],
            'metadata' => ['sometimes','array'],
            'location_key' => ['required'],
            'company_key' => ['required']
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
