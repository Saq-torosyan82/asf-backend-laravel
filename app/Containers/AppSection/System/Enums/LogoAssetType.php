<?php

namespace App\Containers\AppSection\System\Enums;

use BenSampo\Enum\Enum;

final class LogoAssetType extends Enum
{
    const TV_RIGHT = 'tv_right';
    const SPORT_BRAND = 'sport_brand';
    const SPORT_SPONSOR = 'sport_sponsor';
    const SPORT_CLUB = 'sport_club';
    const SPORT_LEAGUE = 'sport_league';
    const SPORT_CONFEDERATION = 'sport_confederation';
    const SPORT_ASSOCIATION = 'sport_association';
    const CLUB_SPONSOR = 'club_sponsor';
    const SPONSOR_DEFAULT = 'sponsor_default';
    const CLUB_HONOURS = 'club_honours';

    public static function getLogoPath($type)
    {
        switch ($type) {
            case self::TV_RIGHT:
                return 'tv-rights';

            case self::SPORT_BRAND:
                return 'sport-brands';

            case self::SPORT_SPONSOR:
                return 'sport-sponsors';

            case self::SPORT_CLUB:
                return 'sport-clubs';

            case self::SPORT_LEAGUE:
                return 'sport-leagues';

            case self::SPORT_CONFEDERATION:
                return 'sport-confederations';

            case self::SPORT_ASSOCIATION:
                return 'sport-associations';

            case self::CLUB_SPONSOR:
                return 'club-sponsors';

            case self::CLUB_HONOURS:
                return 'club-honours';
        }

        return '';
    }

    public static function getDefaultLogoFile($type)
    {
        switch ($type) {
            case self::SPONSOR_DEFAULT:
                return 'deal.png';
            default:
                return 'league.png';
        }
    }

    public static function getDetaultLogo($type)
    {
        return route('web_system_logo_asset', ['default', self::getDefaultLogoFile($type)]);
    }

}
