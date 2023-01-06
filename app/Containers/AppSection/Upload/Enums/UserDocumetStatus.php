<?php

namespace App\Containers\AppSection\Upload\Enums;

use BenSampo\Enum\Enum;

final class UserDocumetStatus extends Enum
{
    const PENDING = 0;
    const ACCEPTED = 1;
    const REJECTED = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::PENDING:
                return 'Pending';

            case self::ACCEPTED:
                return 'Accepted';

            case self::REJECTED:
                return 'Rejected';
        }
        return parent::getDescription($value);
    }
}
