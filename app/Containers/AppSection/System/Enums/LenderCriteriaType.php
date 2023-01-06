<?php

namespace App\Containers\AppSection\System\Enums;

use BenSampo\Enum\Enum;

final class LenderCriteriaType extends Enum
{
    const LENDER_TYPE = 'lender_type';
    const DEAL_TYPE = 'deal_type';
    const CURRENCY = 'currency';
    const MIN_AMOUNT = 'min_amount';
    const MAX_AMOUNT = 'max_amount';
    const MIN_TENOR = 'min_tenor';
    const MAX_TENOR = 'max_tenor';
    const MIN_INTEREST = 'min_interest';
    const INTEREST_RANGE = 'interest_range';
}
