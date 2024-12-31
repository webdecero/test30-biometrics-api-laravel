<?php

return [
    'model' =>  Webdecero\Package\Core\Models\Image::class,
    'store' =>
    [
        'rules' => [
            'image' => ['image','extensions:jpge,jpg,gif,webp,png', 'required_without:imageBase64'],
            'imageBase64' => ['string', 'required_without:image'],
            'workspace' => ['required', 'alpha_dash'],
            'disk' => ['required'],
            'isSave' => ['required'],


            'folder' =>  ['sometimes', 'string'],
            'quality'  => ['sometimes', 'numeric', 'between:1,100'],
            'name' =>  ['sometimes', 'alpha_dash'],
            'title' =>  [ 'string','required_without:image'],
            'alt' =>  [ 'string', 'required_without:image'],
            'format' => ['sometimes', Illuminate\Validation\Rule::in(['jpge', 'jpg', 'gif','webp','png'])],
            'resize' =>  ['sometimes', 'numeric'],
            'thumb' =>  ['sometimes', 'numeric', 'between:1,100'],
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
            'path' => ['required','string'],
            'pathThumb' => ['sometimes', 'string'],
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
