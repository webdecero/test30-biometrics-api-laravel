<?php

return [
    'inputBoolean' => [
        'type' => 'Switch',
        'variant' => 'none',
        'placeholder' => 'Selecciona un valor',
        'values' => [
            [
                'label' => 'Verdadero',
                'value' => true,
            ],
            [
                'label' => 'falso',
                'value' => false,
            ]
        ],
    ],
    'inputInteger' => [
        'type' => 'TextField',
        'variant' => 'number',
        'placeholder' => 'Selecciona un valor',
    ],
    'inputString'=>[
        'type' => 'TextField',
        'variant' => 'text',
        'placeholder' => 'Selecciona un valor',
        'values' => [
            [
                'label' => 'Verdadero',
                'value' => true,
            ],
            [
                'label' => 'falso',
                'value' => false,
            ]
        ],
    ],
    'inputSelect'=>[
        'type' => 'BasicSelect',
        'variant' => 'Empty-Option-None',
        'placeholder' => 'Selecciona un valor',
        'values' => [
            [
                'label' => 'Valor 1',
                'value' => 'valor_1',
            ],
            [
                'label' => 'Valor 2',
                'value' => 'valor_2',
            ]
        ],
    ],
    'timePicker'=>[
        'type' => 'minutes',
        'variant' => 'Empty-Option-None',
        'placeholder' => 'Selecciona un valor',
    ],
];
