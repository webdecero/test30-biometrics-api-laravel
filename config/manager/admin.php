<?php

return [
    'model' =>  Webdecero\Manager\Api\Models\Admin::class,
    'login' =>  [
        'redirectAuth' => '/dashboard'
    ],
  
    'store' =>
    [
        'rules' => [
            'name' =>  ['required', 'regex:/^[a-zA-Z0-9]+(?:\s+[a-zA-Z0-9]+)*$/'],
            'email' =>  ['required', 'unique:admins,email', 'max:255'],
            'phone' => ['required', 'min:10'],
            'password' => ['required', 'min:5', 'confirmed'],
            'status' => ['required'],
            'avatar' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'attachment' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeFile],
            'scopes' => ['sometimes', 'array'],
            'description' => ['string'],
            'metadata' => ['array']
        ],
        'autorize' => []
    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required', 'regex:/^[a-zA-Z0-9]+(?:\s+[a-zA-Z0-9]+)*$/'],
            'email' => ['required', 'max:255'],
            'phone' => ['min:10'],
            'password' => 'sometimes|min:5|confirmed',
            'status' => ['required'],
            'avatar' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'attachment' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeFile],
            'scopes' => ['sometimes', 'array'],
            'description' => ['string'],
            'metadata' => ['array']
        ],
        'autorize' => []


    ],
    'updatePassword' =>
    [
        'rules' => [
            'password' => ['required', 'min:5', 'confirmed']
        ],

    ],


    'destroy' =>
    [
        'childs' => [],
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
    ],
];
