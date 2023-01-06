<?php

namespace App\Containers\AppSection\Deal\Enums;

use BenSampo\Enum\Enum;

final class DealUpload extends Enum
{
    const TERM_SHEET = 'term_sheet';
    const DRAFT_CONTRACT = 'draft_contract';
    const CREDIT_ANALYSIS = 'credit_analysis';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::TERM_SHEET:
                return 'Termsheet';

            case self::DRAFT_CONTRACT:
                return 'Draft contract';

            case self::CREDIT_ANALYSIS:
                return 'Credit analysis';
        }

        return parent::getDescription($value);
    }
}

