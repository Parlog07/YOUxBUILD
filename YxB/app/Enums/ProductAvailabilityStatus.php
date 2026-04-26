<?php

namespace App\Enums;

enum ProductAvailabilityStatus: string
{
    case IN_STOCK = 'in_stock';
    case OUT_OF_STOCK = 'out_of_stock';
    case PREORDER = 'preorder';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
