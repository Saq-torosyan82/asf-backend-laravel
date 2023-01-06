<?php

/**
 * @apiGroup           Deal
 * @apiName            getDealsCountByCountry
 *
 * @api                {GET} /v1/admin/deals-by-country Get Deals by Country
 * @apiDescription     This endpoint is used to get the count of deals by country.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": [
        {
            "label": "Austria",
            "number": 1,
            "key": "AUT"
        },
        {
            "label": "Bulgaria",
            "number": 12,
            "key": "BGR"
        },
        {
            "label": "England",
            "number": 1,
            "key": "GB-ENG"
        },…
    ]
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('admin/deals-by-country', [Controller::class, 'getDealsByCountry'])
    ->name('api_userprofile_admin_get_deals_by_country')
    ->middleware(['auth:api']);

