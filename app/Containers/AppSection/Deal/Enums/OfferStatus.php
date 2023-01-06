<?php

namespace App\Containers\AppSection\Deal\Enums;

use BenSampo\Enum\Enum;

final class OfferStatus extends Enum
{
    const NEW = 'new';
    const REJECTED = 'rejected';
    const ACCEPTED = 'accepted';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::NEW:
                return 'New';

            case self::REJECTED:
                return 'Rejected';

            case self::ACCEPTED:
                return 'Accepted';
        }

        return parent::getDescription($value);
    }
}

