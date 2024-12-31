<?php


return [
    'model' =>  Webdecero\Manager\Api\Models\Notification::class,
    'clicked' =>
    [
        'autorize' => [],
        'rules' => [
            'clicked' => ['required']
        ]
    ],
    'destroy' =>
    [
        'childs' => [
        ],
        'autorize' => []


    ]
];
