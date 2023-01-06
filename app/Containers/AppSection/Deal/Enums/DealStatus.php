<?php

namespace App\Containers\AppSection\Deal\Enums;

use BenSampo\Enum\Enum;

final class DealStatus extends Enum
{
    const NOT_STARTED = 'not_started';
    const IN_PROGRESS = 'in_progress';
    const REJECTED = 'rejected';
    const ACCEPTED = 'accepted';
    const LIVE = 'live';
    const STARTED = 'started';
    const COMPLETED = 'completed';

    public static function getDescription($value):string
    {
        switch ($value) {
            case self::NOT_STARTED:
                return 'In progress';

            case self::IN_PROGRESS:
                return 'Under review';

            case self::REJECTED:
                return 'Rejected';

            case self::ACCEPTED:
                return 'Accepted';

            case self::LIVE:
                return 'Live';

            case self::STARTED:
                return 'Started';

            case self::COMPLETED:
                return 'Done/Completed ';
        }

        return parent::getDescription($value);
    }
}

