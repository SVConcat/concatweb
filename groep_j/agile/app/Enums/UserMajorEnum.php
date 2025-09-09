<?php

namespace App\Enums;

enum UserMajorEnum: string
{
    case SO = 'SO';
    case BI = 'BI';

    public static function toArray(): array
    {
        return [
            self::SO->value,
            self::BI->value,
        ];
    }
}
