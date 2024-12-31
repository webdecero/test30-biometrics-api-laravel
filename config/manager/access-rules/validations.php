<?php

use App\Enums\AccessRulesOperatorTypes;
use App\Enums\AccessRulesValuesTypes;




$operatorsConfig = config('manager.access-rules.operators');

return [

    //Context
    'User' =>
    [
        'model' =>  \App\Models\User::class,
        'relation' => 'root',
        'rules' => [
            'status' => [
                'cast' => AccessRulesValuesTypes::BOOLEAN,
                'operators' => [AccessRulesOperatorTypes::EQUAL, AccessRulesOperatorTypes::NOT_EQUAL],
                'component' => [
                    'key'=> 'inputBoolean',
                ],
            ],
            'validAccess' => [
                'cast' => AccessRulesValuesTypes::BOOLEAN,
                'operators' => [AccessRulesOperatorTypes::EQUAL],
                'component' => [
                    'key'=> 'inputInteger',
                ],
            ],
            'locations' => [
                'cast' => AccessRulesValuesTypes::BOOLEAN,
                'operators' => [AccessRulesOperatorTypes::EQUAL],
                'component' => [
                    'key'=> 'inputString',
                    'placeholder' => 'placeholder de prueba',
                    'values' => [
                        [
                            'label' => 'prueba',
                            'value' => true,
                        ],
                        [
                            'label' => 'prueba2',
                            'value' => false,
                        ]
                    ],
                ]
            ],
        ],
    ],
    'Group' =>
    [
        'model' =>  \App\Models\User::class,
        'relation' => 'root',
        'rules' => [
            'status' => [
                'cast' => AccessRulesValuesTypes::BOOLEAN,
                'operators' => [AccessRulesOperatorTypes::EQUAL],
                'component' => [
                    'key'=> 'inputSelect',
                ],
            ],
            'validAccess' => [
                'cast' => AccessRulesValuesTypes::BOOLEAN,
                'operators' => [AccessRulesOperatorTypes::EQUAL],
                'component' => [
                    'key'=> 'inputSelect',
                ],
            ],
            'locations' => [
                'cast' => AccessRulesValuesTypes::BOOLEAN,
                'operators' => [AccessRulesOperatorTypes::EQUAL],
                'component' => [
                    'key'=> 'timePicker',
                ],
            ],
        ],
    ],
];
