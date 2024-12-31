<?php

use App\Enums\AccessRulesOperatorTypes;

return [
    AccessRulesOperatorTypes::EQUAL->value  => 'Es igual a',
    AccessRulesOperatorTypes::NOT_EQUAL->value => 'No es igual a',
    AccessRulesOperatorTypes::GREATER_THAN->value => 'Es mayor que',
    AccessRulesOperatorTypes::GREATER_THAN_EQUAL->value => 'Es mayor o igual que',
    AccessRulesOperatorTypes::LOW_THAN_EQUAL->value => 'Es menor o igual que',
    AccessRulesOperatorTypes::WHERE_IN->value => 'Está en',
    AccessRulesOperatorTypes::WHERE_NOT_IN->value => 'No está en',
];
