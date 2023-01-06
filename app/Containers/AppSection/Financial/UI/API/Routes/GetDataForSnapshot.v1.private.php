<?php

/**
 * @apiGroup           Financial
 * @apiName            getDataForSnapshot
 *
 * @api                {GET} /v1/financial-snapshot-report/:club_id? Get Data For Financial Snapshot Report
 * @apiDescription     Get all necessary data for the financial snapshot report. If the authenticated user is a corporate user, the club_id will be fetched automatically, otherwise the club_id must be sent.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Corporate User or Lender User or Admin
 * @apiParam           {String}  [selected_currency] If the selected_currency parameter is sent, the values are presented according to that currency, otherwise the values are presented in the saved currency chosen by that specific sport organization
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "tabs": […],
    "defaultCurrency": 'gbp',
    "intervals": […],
    "seasons": […],
    "positions": […]
    "club": {
        "id": "…",
        "name": "…",
        "logo": "…",
        "league": {
            "name": "…",
            "logo": "…"
        },
        "country": "…"
    }
}
 */

use App\Containers\AppSection\Financial\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('financial-snapshot-report/{club_id?}', [Controller::class, 'getDataForSnapshot'])
    ->name('api_financial_get_data_for_snapshot')
    ->middleware(['auth:api']);

