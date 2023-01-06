<?php

namespace App\Containers\AppSection\Communication\Enums;

use BenSampo\Enum\Enum;

final class CommunicationType extends Enum
{
    const DEALS = 1;
    const SERVICE = 2;

    public static function getText($value) {
        switch ($value)
        {
            case self::DEALS:
                return "deals";
            case self::SERVICE:
                return "service center";
            default:
                return '';
        }
    }
}
