<?php

namespace App\Containers\AppSection\Payment\Enums;

use BenSampo\Enum\Enum;

final class PaymentStatus extends Enum
{
    const PENDING = 'pending';
    const DELAYED = 'delayed';
    const PAID = 'paid';


    public static function getDescription($value): string
    {
        switch ($value) {
            case self::PENDING:
                return 'Pending';

            case self::DELAYED:
                return 'Delayed';

            case self::PAID:
                return 'Paid';
        }

        return ucwords($value);
    }
}
