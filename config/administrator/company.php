<?php

return [
    'model' =>  \App\Models\Company::class,
    'store' =>
    [
        'rules' => [

            'key' => ['required','string'],
            'name' => ['required','string'],
            'email' => ['required','string'],
            'status' => ['required'],
            'step' => ['required'],
            'isMultiLocation' => ['required', 'string'],
            'isGroupActive'=> ['required','string'],
            'metadata' => ['sometimes', 'array'],
            // 'plesk' => ['required','array'],
            // 'managerDomain' => ['required','array'],
            // 'apiDomain' => ['required','array'],
            // 'notifyDomain' => ['required','array'],
            // 'mongoDB' => ['required','array'],
            // 'mysqlDB' => ['required','array'],
            // 'mysqlUser' => ['required','array'],
            // 'apiClient' => ['required','array'],

        ],
        'autorize' => []
    ],
    'update' =>
    [
        'rules' => [

            'name' => ['required','string'],
            'email' => ['required','string'],
            'status' => ['required'],
            'step' => ['required'],
            'isMultiLocation' => ['required', 'string'],
            'isGroupActive'=> ['required','string'],
            'metadata' => ['sometimes', 'array'],
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
            ],
            [
                'key' => 'email',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'step',
                'operation' => '$eq'
            ],
            [
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
