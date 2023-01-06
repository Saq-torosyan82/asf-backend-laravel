<?php

namespace App\Containers\AppSection\Financial\Enums;

use BenSampo\Enum\Enum;

final class FinancialDocumentsStatus extends Enum
{
    const UPLOADED = 0;
    const PENDING = 1;
    const ACCEPTED = 2;
    const REJECTED = 3;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::PENDING:
                return 'To be verified';

            case self::ACCEPTED:
                return 'Verified';

            case self::REJECTED:
                return 'Rejected';
        }
        return parent::getDescription($value);
    }

    public static function getActualStatus($value = null)
    {
        if ($value === null || $value == self::REJECTED) {
            return 'allow_upload';
        }
        switch ($value) {
            case self::PENDING:
                return 'pending';
            case self::ACCEPTED:
                return 'accepted';
            default: return 'edit';
        }

    }
}
