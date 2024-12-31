<?php
return [

    //Context
    [
        'key' => 'User.status',
        'model' =>  'User',
        'property' => 'status',
        'cast' => 'boolean',
        'operators' => [
            [
                'key' => 'equal',
                'value' => 'Igual',
            ],
            [
                'key' => 'not_equal',
                'value' => 'Diferente',
            ],
        ],
        'componet' => [
            'type' => 'select',
            'placeholder' => 'Selecciona un valor',

            'values' => [
                [
                    'key' => true,
                    'value' => 'Activo',
                ],
                [
                    'key' => false,
                    'value' => 'Inactivo',
                ]
            ],
        ],

    ],
    [
        'key' => 'Group.status',
        'model' =>  'Group',
        'property' => 'status',
        'propertyType' => 'boolean',
        'operators' => [
            [
                'key' => 'equal',
                'value' => 'Igual',
            ],
            [
                'key' => 'not_equal',
                'value' => 'Diferente',
            ],
        ],
        'componet' => [
            'type' => 'select',
            'placeholder' => 'Selecciona un valor',
            'values' => [
                [
                    'key' => true,
                    'value' => 'Activo',
                ],
                [
                    'key' => false,
                    'value' => 'Inactivo',
                ]
            ],
        ],

    ],

];
