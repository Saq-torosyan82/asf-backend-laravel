<?php

/**
 * @apiGroup           System
 * @apiName            getAllCountries
 *
 * @api                {GET} /v1/system/countries Get all countries list
 * @apiDescription     Get all countries list
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
"data": [
    {
    "id": "NxOpZowo9GmjKqdR",
    "name": "Afghanistan"
    },
    ...
],
    "meta": {
    "include": [],
    "custom": []
    }
}
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('system/countries', [Controller::class, 'getAllCountries'])
    ->name('api_system_countries')
    ->middleware(['auth:api']);

