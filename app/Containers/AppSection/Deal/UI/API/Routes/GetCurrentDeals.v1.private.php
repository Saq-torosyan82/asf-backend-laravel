<?php

/**
 * @apiGroup           Deal
 * @apiName            getCurrentDeals
 *
 * @api                {GET} /v1/deals-current Get Current deals
 * @apiDescription     Get current deals
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
            "id": "p6ELeYGQ9XGZ1PjW",
            "type": "endorsement",
            "type_label": "Endorsement",
            "status": "started",
            "status_label": "Started",
            "reason": "contract_signed",
            "reason_label": "Contract signed by both parties",
            "start_date": "2022-01-12T00:00:00.000000Z",
            "finish_date": "2026-12-16",
            "currency": "GBP",
            "contract_amount": 1999900,
            "net_amount": 0,
            "paid_back": 0,
            "status_bar": {
            "percentaje": 100,
            "label": "Contract signed by both parties"
            },
            "counterparty": {
            "name": "Luluemon athletica",
            "avatar": "https://api.asf.stage.nextus.ro/storage/logo/sport-brands/lululemon-athletica.png"
            },
            "lender": {
            "name": ""
            },
            "borrower": {
            "name": "First55 Last55",
            "avatar": "230"
            }
            }
    ],
    "meta": {
    "include": [],
    "custom": [],
    "pagination": {
    "total": 1,
    "count": 1,
    "per_page": 10,
    "current_page": 1,
    "total_pages": 1,
    "links": {}
    }
    }
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('deals-current', [Controller::class, 'getCurrentDeals'])
    ->name('api_deal_get_current_deals')
    ->middleware(['auth:api']);

