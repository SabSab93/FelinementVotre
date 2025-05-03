<?php

namespace App\Enum;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case UNKNOWN = 'unknown';

    public static function toString(self $gender): string
    {
        return $gender->value;
    }
}
