<?php

return [
    'model' =>  \App\Models\User::class,


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
            ],

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


    ]

];
