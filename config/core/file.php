<?php

return [
    'model' =>  Webdecero\Package\Core\Models\File::class,
    'store' =>
    [
        'rules' => [
            'file' => ['file', 'required'],
            'workspace' => ['required', 'alpha_dash'],
            'disk' => ['required'],
            'isSave' => ['required'],


            'folder' =>  ['sometimes', 'string'],
            'name' =>  ['sometimes', 'alpha_dash'],
            'title' =>  [ 'string','required_without:image'],
            'isOverwrite' =>  ['sometimes'],



            'tags' =>  ['sometimes', 'array'],
            'metadata' =>  ['sometimes', 'array'],
            'category' =>  ['sometimes', 'alpha_dash'],

        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            'name' => 'sometimes|string',
            'file' => 'required|file',
            'namespace' => 'required|string',
        ],
        'autorize' => []


    ],
    'destroy' =>
    [
        'childs' => [
        ],
        'autorize' => []


    ],
    'delete' =>
    [
        'rules' => [
            'disk' => ['required'],
            'path' => ['required','string']
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
                'key' => 'metadata.location',
                'operation' => '$eq'
            ],
            [
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
