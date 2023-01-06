<?php

namespace App\Containers\AppSection\UserSponsorship\Enums;

use App\Containers\AppSection\Financial\Enums\FactSectionsName;
use BenSampo\Enum\Enum;

final class Key extends Enum
{
    const BRAND_TYPE = "brand";
    const SPONSOR_TYPE = "sponsor";

    const SHIRT_TYPE = 'shirt';
    const SLEEVE_TYPE = 'sleeve';
    const KIT_TYPE = 'kit';
    const MAIN_PARTNER_TYPE = 'main_partner';




    public static function isUniqueType($type)
    {
        $map = [
            self::SLEEVE_TYPE => 1,
            self::KIT_TYPE => 1,
            self::SHIRT_TYPE => 1,
        ];

        return isset($map[$type]);
    }

    public static function mapClubSponsorKeys(): array
    {
        return [
           self::SHIRT_TYPE => 'Shirt sponsor',
           self::SLEEVE_TYPE => 'Sleeve sponsor',
           self::KIT_TYPE => 'Kit sponsor',
           self::MAIN_PARTNER_TYPE => 'Main sponsor',
        ];
    }

    public static function getTypeById(int $id)
    {
        $map = self::mapTypes();

        return isset($map[$id]) ? $map[$id] : null;
    }

    protected static function mapTypes(): array
    {
        return [
            FactSectionsName::SHIRT_ID => self::SHIRT_TYPE,
            FactSectionsName::SLEEVE_ID => self::SLEEVE_TYPE,
            FactSectionsName::KIT_ID => self::KIT_TYPE,
            FactSectionsName::MAIN_CURRENT_PARTNERS_ID => self::MAIN_PARTNER_TYPE,

        ];
    }




}
