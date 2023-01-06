<?php

namespace App\Containers\AppSection\Deal\Enums;

use BenSampo\Enum\Enum;

final class InstallmentFrequency extends Enum
{
    const MONTHLY = 'monthly';
    const QUARTERLY = 'quarterly';
    const YEARLY = 'yearly';
    const CUSTOM = 'custom';

    public static function getNumericValue($value): int
    {
        switch ($value) {
            case self::MONTHLY:
                return 1;
            case self::QUARTERLY:
                return 3;
//            case self::SEMIANNUAL:
//                return 6;
            case self::YEARLY:
                return 12;
            default: return 0;
        }

    }
}
