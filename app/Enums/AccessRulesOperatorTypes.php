<?php
namespace App\Enums;


enum AccessRulesOperatorTypes: string
{
    case EQUAL = 'equal';
    case NOT_EQUAL = 'not_equal';
    case GREATER_THAN = 'greater_than';
    case LOW_THAN = 'low_than';
    case GREATER_THAN_EQUAL = 'greater_than_equal';
    case LOW_THAN_EQUAL = 'low_than_equal';
    case WHERE_IN = 'where_in';
    case WHERE_NOT_IN = 'where_not_in';
}
