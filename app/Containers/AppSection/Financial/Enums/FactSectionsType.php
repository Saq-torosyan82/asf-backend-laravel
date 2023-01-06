<?php

namespace App\Containers\AppSection\Financial\Enums;

use BenSampo\Enum\Enum;

final class FactSectionsType extends Enum
{
    const MAIN_CLUB_HONOURS = 'Main Club Honours';
    const CURRENT_SPONSORS = 'Current Sponsors';
    const SOCIAL_MEDIA = 'Social Media';
    const COMPETITION_POSITION_FINISH = 'Competition Position Finish';
    const PLAYER_TRADING = 'Player Trading';
    const MANAGERS_PER_YEAR = 'Managers per year';

    public static function getId($value) {
        switch ($value)
        {
            case self::MAIN_CLUB_HONOURS:
                return 1;

            case self::CURRENT_SPONSORS:
                return 2;

            case self::SOCIAL_MEDIA:
                return 3;

            case self::COMPETITION_POSITION_FINISH:
                return 4;

            case self::PLAYER_TRADING:
                return 5;

            case self::MANAGERS_PER_YEAR:
                return 6;
        }

    }
}
