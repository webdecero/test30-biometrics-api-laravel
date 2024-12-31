<?php

return [
    'model' =>  Webdecero\Manager\Api\Models\Admin::class,
    'login' =>  [
        'redirectAuth' => '/',
        'redirectLogout' => '/'
    ],
    'updateProfile' =>
    [
        'autorize' => [],
        'rules' => [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'max:255'],
            'phone' => ['min:10'],
            'password' => ['sometimes', 'min:6'],
            'status' => ['required'],
            'avatar' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage(['public'])],
            'attachment' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeFile],
            'scopes' => ['sometimes', 'array'],
            'description' => ['string'],
            'metadata' => ['array']
        ],


    ],
    'password' =>
    [
        'autorize' => [],
        'rules' => [
            'password' => ['required', 'min:6', 'confirmed']
        ],

    ]
];
