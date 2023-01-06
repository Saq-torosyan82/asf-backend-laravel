<?php

namespace App\Containers\AppSection\System\Enums;

use BenSampo\Enum\Enum;
use phpDocumentor\Reflection\Types\Self_;

final class Currency extends Enum
{
    const EUR = 'eur';
    const USD = 'usd';
    const GBP = 'gbp';

    public static function getDescription($value): string
    {
        switch ($value)
        {
            case self::EUR:
                return 'EUR';

            case self::USD:
                return 'USD';

            case self::GBP:
                return 'GBP';
        }

        return parent::getDescription($value);
    }

    public static function getLabels($value): string
    {
        $label = '';
        switch ($value)
        {
            case self::EUR:
                $label = '€ EURO';
                break;
            case self::USD:
                $label = '$ USD';
                break;
            case self::GBP:
                $label = '£ GBP';
                break;
        }

        return $label;
    }

    public static function getAllCurrencies() {
        return [
            [
                'text' => self::getDescription(self::GBP),
                'label' => self::getLabels(self::GBP),
                'value' => self::GBP,
            ],
            [
                'text'  => self::getDescription(self::EUR),
                'label' => self::getLabels(self::EUR),
                'value' => self::EUR,
            ],
            [
                'text' => self::getDescription(self::USD),
                'label' => self::getLabels(self::USD),
                'value' => self::USD,
            ]
        ];
    }

    public static function isEUR($value): bool
    {
        return strtolower($value) == self::EUR;
    }

    public static function isUSD($value): bool
    {
        return strtolower($value) == self::USD;
    }

    public static function isGBP($value): bool
    {
        return strtolower($value) == self::GBP;
    }

}
