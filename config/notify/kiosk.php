<?php

return [
    'model' =>  \App\Models\Kiosk::class,
    'valid' =>
    [
        'rules' => [

            'terminalKey' => ['required'],
            'deviceId' => ['required'],

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
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
