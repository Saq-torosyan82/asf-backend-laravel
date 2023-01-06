<?php

namespace App\Containers\AppSection\Rate\Enums;

use BenSampo\Enum\Enum;

final class Configs extends Enum
{
    const BASE_CURRENCY = 'GBP';
    const BASE_CURRENCY_RATE = 1;
    const ENDPOINT_URL = 'https://api.frankfurter.app/latest?from=';
}
