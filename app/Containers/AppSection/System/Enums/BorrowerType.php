<?php

namespace App\Containers\AppSection\System\Enums;

use BenSampo\Enum\Enum;

final class BorrowerType extends Enum
{
    // TYPE
    const ATHLETE = 'athlete';
    const AGENT = 'agent';
    const CORPORATE = 'corporate';

    // NAME
    const FINANCIAL_MANAGER = 'Financial Manager';
    const PROFESSIONAL_ATHLETE = 'Professional Athlete';
    const PROFESSIONAL_COACH = 'Professional Coach';
    const SPORTS_AGENT = 'Sports Agent';
    const SPORTS_LAWYER = 'Sports Lawyer';
    const SPORTS_ORGANIZATION = 'Sports Organization';
    const SPORTS_MARKETING_AGENCY = 'Sports Marketing Agency';

    //DB ids

    const FINANCIAL_MANAGER_ID = 1;
    const PROFESSIONAL_ATHLETE_ID = 2;
    const PROFESSIONAL_COACH_ID = 7;
    const SPORTS_AGENT_ID = 3;
    const SPORTS_LAWYER_ID = 4;
    const SPORTS_ORGANIZATION_ID = 5;
    const SPORTS_MARKETING_AGENCY_ID = 6;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::PROFESSIONAL_ATHLETE:
                return 'Professional Athlete (ie. Footballer)';
            case self::SPORTS_ORGANIZATION:
                return 'Sport Organization (ie. Team, League, Federation)';
        }

        return $value;
    }

    public static function getId($value)
    {
        switch ($value) {
            case self::FINANCIAL_MANAGER:
                return self::FINANCIAL_MANAGER_ID;

            case self::PROFESSIONAL_ATHLETE:
                return self::PROFESSIONAL_ATHLETE_ID;

            case self::SPORTS_AGENT:
                return self::SPORTS_AGENT_ID;

            case self::SPORTS_LAWYER:
                return self::SPORTS_LAWYER_ID;

            case self::SPORTS_ORGANIZATION:
                return self::SPORTS_ORGANIZATION_ID;

            case self::SPORTS_MARKETING_AGENCY:
                return self::SPORTS_MARKETING_AGENCY_ID;

            case self::PROFESSIONAL_COACH:
                return self::PROFESSIONAL_COACH_ID;
        }

    }
}
