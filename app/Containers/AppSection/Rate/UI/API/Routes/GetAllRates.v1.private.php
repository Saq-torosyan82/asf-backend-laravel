<?php

/**
 * @apiGroup           Rate
 * @apiName            getAllRates
 *
 * @api                {GET} /v1/rates Get All Rates
 * @apiDescription     Get list of all rates in GBP
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "EUR": 1.2103,
    "USD": 1.3186
}
 */

use App\Containers\AppSection\Rate\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('rates', [Controller::class, 'getAllRates'])
    ->name('api_rate_get_all_rates')
    ->middleware(['auth:api']);
