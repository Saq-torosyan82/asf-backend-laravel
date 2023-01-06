<?php

namespace App\Containers\AppSection\Financial\Enums;

use BenSampo\Enum\Enum;

final class FactSectionsName extends Enum
{
    const STADIUM_NAME = 'Stadium Name';
    const CAPACITY = 'Capacity';
    const FOUNDED = 'Founded';
    const OWNER_S = 'Owner(s)';
    const MANAGER = 'Manager';
    const SHIRT = 'Shirt';
    const SLEEVE = 'Sleeve';
    const KIT = 'Kit';
    const MAIN_CURRENT_PARTNERS = 'Main current partners';

    const FACEBOOK_KEY = 'facebook';
    const INSTAGRAM_KEY = 'instagram';
    const TWITTER_KEY = 'twitter';
    const LINKEDIN_KEY = 'linkedin';

    const STADIUM_NAME_KEY = 'stadium_name';
    const CAPACITY_KEY = 'stadium_capacity';

    const FACEBOOK_ID = 31;
    const INSTAGRAM_ID = 32;
    const TWITTER_ID = 33;
    const LINKEDIN_ID = 34;

    const STADIUM_NAME_ID = 17;
    const CAPACITY_ID = 18;
    const FOUNDED_ID = 6;
    const OWNER_S_ID = 8;
    const MANAGER_ID = 10;
    const SHIRT_ID = 27;
    const SLEEVE_ID = 28;
    const KIT_ID = 29;
    const MAIN_CURRENT_PARTNERS_ID = 30;

    public static function getId($value)
    {
        $map = self::getMap();

        return isset($map[$value]) ? $map[$value] : null;
    }

    public static function getNameById(int $id)
    {
        $map = array_flip(self::getMap());

        return isset($map[$id]) ? $map[$id] : null;
    }

    public static function getSocialMediaKeyById(int $id)
    {
        $map = self::mapSocialMediaFacts();

        return isset($map[$id]) ? $map[$id] : null;
    }

    public static function getStadiumKeyById(int $id)
    {
        $map = self::mapStadiumFacts();

        return isset($map[$id]) ? $map[$id] : null;
    }

    protected static function getMap(): array
    {
        return [
            self::STADIUM_NAME => self::STADIUM_NAME_ID,
            self::CAPACITY => self::CAPACITY_ID,
            self::FOUNDED => self::FOUNDED_ID,
            self::OWNER_S => self::OWNER_S_ID,
            self::MANAGER => self::MANAGER_ID,
            self::SHIRT => self::SHIRT_ID,
            self::SLEEVE => self::SLEEVE_ID,
            self::KIT => self::KIT_ID,
            self::MAIN_CURRENT_PARTNERS => self::MAIN_CURRENT_PARTNERS_ID,
        ];
    }

    protected static function mapSocialMediaFacts(): array
    {
        return [
            self::FACEBOOK_ID => self::FACEBOOK_KEY,
            self::INSTAGRAM_ID => self::INSTAGRAM_KEY,
            self::TWITTER_ID => self::TWITTER_KEY,
            self::LINKEDIN_ID => self::LINKEDIN_KEY
        ];
    }

    protected static function mapStadiumFacts(): array
    {
        return [
            self::STADIUM_NAME_ID => self::STADIUM_NAME_KEY,
            self::CAPACITY_ID => self::CAPACITY_KEY,
        ];
    }

    public static function socialMediaFactsIds(): array
    {
        return [
            self::FACEBOOK_ID,
            self::INSTAGRAM_ID,
            self::TWITTER_ID,
            self::LINKEDIN_ID
        ];
    }

    public static function stadiumFactsIds(): array
    {
        return [
            self::STADIUM_NAME_ID,
            self::CAPACITY_ID,
        ];
    }


    public static function clubFactsIds(): array
    {
        return [
            self::SHIRT_ID,
            self::SLEEVE_ID,
            self::KIT_ID,
            self::MAIN_CURRENT_PARTNERS_ID
        ];
    }
}
