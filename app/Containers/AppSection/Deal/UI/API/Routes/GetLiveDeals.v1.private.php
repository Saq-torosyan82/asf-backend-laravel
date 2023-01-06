<?php

/**
 * @apiGroup           Deal
 * @apiName            GetLiveDeals
 *
 * @api                {GET} /v1/live-deals Get live deals
 * @apiDescription     Get live deals
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
        "id": "KMQYEXGDgpzgRPeZ",
        "type": "endorsement",
        "type_label": "Endorsement",
        "status": "live",
        "status_label": "Live",
        "country": "France",
        "start_date": "2022-04-30T00:00:00.000000Z",
        "borrower": "Test CinciDoi",
        "lender": "First100 Last100",
        "sport": "Football",
        "counterparty": "Hummel",
        "currency": "USD",
        "contract_amount": 91978099,
        "interest_rate": 7,
        "terms_accepted": 0,
        "is_matched": false
        },
    ...
    ],
    "meta": {
    "include": [],
    "custom": []
    },
    "totalAmount": "86,845,512.70",
    "sorting": [],
    "filtering": []
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('deals-live', [Controller::class, 'getLiveDeals'])
    ->name('api_deal_get_live_deals')
    ->middleware(['auth:api']);

