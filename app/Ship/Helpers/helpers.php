<?php
namespace App\Ship\Helpers;
/*
|--------------------------------------------------------------------------
| Ship Helpers
|--------------------------------------------------------------------------
|
| Write only general helper functions here.
| Container specific helper functions should go into their own related Containers.
| All files under app/{section_name}/{container_name}/Helpers/ folder will be autoloaded by Apiato.
|
*/

use App\Containers\AppSection\Rate\Enums\Configs;

if (!function_exists('exchangeRate')) {
    function exchangeRate($currencyFrom, $currencyTo, $amount, $rates)
    {
        $currencyFrom = strtoupper($currencyFrom);
        $currencyTo = strtoupper($currencyTo);
        if ($currencyFrom == $currencyTo) {
            return $amount;
        } else {
            if ($currencyFrom == Configs::BASE_CURRENCY) {
                $rates[$currencyFrom] = Configs::BASE_CURRENCY_RATE;
            }

            if ($currencyTo == Configs::BASE_CURRENCY) {
                $rates[$currencyTo] = Configs::BASE_CURRENCY_RATE;
            }

            return $amount * $rates[$currencyTo] / $rates[$currencyFrom];
        }
    }
}
