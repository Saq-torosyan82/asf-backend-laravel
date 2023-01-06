<?php

/**
 * @apiGroup           System
 * @apiName            GetAllBorrowerTypes
 *
 * @api                {GET} /v1/system/borrower-types Get all borrower types
 * @apiDescription     Get all borrower types
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
        "id": "O9apoVGyLz5qNX4K",
        "name": "Sports Organization",
        "label": "Sport Organization (ie. Team, League, Federation)",
        "type": "corporate"
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

Route::get('system/borrower-types', [Controller::class, 'GetAllBorrowerTypes'])
    ->name('api_system_get_all_borrower_types')
    ->middleware(['auth:api']);
