<?php

namespace App\Enum;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case UNKNOWN = 'unknown';

    // Méthode statique pour obtenir la valeur sous forme de chaîne
    public static function toString(self $gender): string
    {
        return $gender->value;
    }
}
