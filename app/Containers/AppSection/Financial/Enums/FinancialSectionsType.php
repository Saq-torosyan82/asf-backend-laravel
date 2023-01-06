<?php

namespace App\Containers\AppSection\Financial\Enums;

use BenSampo\Enum\Enum;

final class FinancialSectionsType extends Enum
{
    const PROFIT_LOSS_SHEET = 'Profit/loss sheet';
    const BALANCE_SHEET = 'Balance sheet';
    const CASH_FLOW = 'Cash flow';
    const KEY_METRICS = 'Key metrics';

    public static function getId($value) {
        switch ($value)
        {
            case self::PROFIT_LOSS_SHEET:
                return 1;

            case self::BALANCE_SHEET:
                return 2;

            case self::CASH_FLOW:
                return 3;

            case self::KEY_METRICS:
                return 4;
        }
    }
}
