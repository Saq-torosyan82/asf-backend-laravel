<?php

namespace App\Containers\AppSection\Communication\Enums;

use BenSampo\Enum\Enum;

final class QuestionType extends Enum
{
    const TECHNICAL_ISSUE = 1;
    const INFORMATION = 2;
    const DEAL_CALCULATOR = 3;

    public static function getText($value) {
        switch ($value)
        {
            case self::TECHNICAL_ISSUE:
                return "Technical issue";
            case self::INFORMATION:
                return "Information";
            case self::DEAL_CALCULATOR:
                return "Deal calculator";
            default:
                return '';
        }
    }
    public static function getAllQuestions() {
        return [
            [
                'id' => self::TECHNICAL_ISSUE,
                'name'=> self::getText(self::TECHNICAL_ISSUE)
            ],
            [
                'id' => self::INFORMATION,
                'name'=> self::getText(self::INFORMATION)
            ],
            [
                'id' => self::DEAL_CALCULATOR,
                'name'=> self::getText(self::DEAL_CALCULATOR)
            ]
        ];

    }
}
