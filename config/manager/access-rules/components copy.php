<?php

use App\Enums\AccessRulesOperatorTypes;

return [
        'inputBoolean' => [
            'placeholder' => 'Seleciona una respuesta',
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
        AccessRulesOperatorTypes::NOT_EQUAL->value => [
            'label' => 'No es igual a',
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
        AccessRulesOperatorTypes::GREATER_THAN->value => [
            'label' => 'Es mayor que',
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
        AccessRulesOperatorTypes::GREATER_THAN_EQUAL->value => [
            'label' => 'Es mayor o igual que',
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
        AccessRulesOperatorTypes::LOW_THAN_EQUAL->value => [
            'label' => 'Es menor o igual que',
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
        AccessRulesOperatorTypes::WHERE_IN->value => [
            'label' => 'Está en',
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
        AccessRulesOperatorTypes::WHERE_NOT_IN->value => [
            'label' => 'No está en',
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


];
