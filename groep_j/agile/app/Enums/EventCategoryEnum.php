<?php

namespace App\Enums;

enum EventCategoryEnum: string
{
    case EVENT = 'EVENT';
    case DRINKS = 'DRINKS';
    case COMMUNITY = 'COMMUNITY';

    public static function toArray(): array
    {
        return [
            self::EVENT->value,
            self::DRINKS->value,
            self::COMMUNITY->value
        ];
    }
}
