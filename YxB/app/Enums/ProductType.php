<?php

namespace App\Enums;

enum ProductType: string
{
    case PHYSICAL = 'physical';
    case PREBUILT_PC = 'prebuilt_pc';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
