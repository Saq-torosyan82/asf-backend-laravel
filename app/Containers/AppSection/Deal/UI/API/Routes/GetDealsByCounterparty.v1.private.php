<?php

/**
 * @apiGroup           Deal
 * @apiName            FindDealsByCounterparty
 *
 * @api                {GET} /v1/deals-by-counterparty Find Deals by Counterparty
 * @apiDescription     This endpoint is used to find deals by the counterparty. The data is returned grouped by deal status.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin
 *
 * @apiParam           {String}  counterparty Counterparty name (example: adidas)
 *
 * @apiParam           {String} [selected_currency] If the selected_currency parameter is sent, the amounts are presented according to that currency, otherwise the values are presented in the default currency (in GBP).
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": {
        "Adidas": {
            "in_progress": {
                "status": "In progress",
                "currency": "GBP",
                "amount": 6681451.70
            },
            "not_started": {
                "status": "Not started",
                "currency": "GBP",
                "amount": 17841559.31
            }
        }
    },
    "totalAmount": 24523011.01
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('deals-by-counterparty', [Controller::class, 'GetDealsByCounterparty'])
    ->name('api_deal_get_detail_deal')
    ->middleware(['auth:api']);

