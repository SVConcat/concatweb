<?php

namespace App\Enums;

enum ActiveTypeEnum: string
{
    case ACTIVE = 'ACTIVE';
    case ARCHIVED = 'ARCHIVED';

    public static function toArray(): array
    {
        return [
            self::ACTIVE->value,
            self::ARCHIVED->value,
        ];
    }
}
