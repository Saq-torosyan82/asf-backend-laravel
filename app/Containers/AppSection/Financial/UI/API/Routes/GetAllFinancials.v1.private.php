<?php

/**
 * @apiGroup           Financial
 * @apiName            getAllFinancials
 *
 * @api                {GET} /v1/financials/:club_id? Get User Financial Data
 * @apiDescription     This endpoint is used to get all financial data of sport organizations. If the authenticated user is a corporate user, the club_id will be fetched automatically, otherwise the club_id must be sent
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin or Corporate User
 *
 * @apiParam           {String}  [selected_currency] If the selected_currency parameter is sent, the values are presented according to that currency, otherwise the values are presented in the saved currency chosen by that specific sport organization
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "positions": [
        "8",…
    ],
    "leagues": [
        "Premier League",…
    ],
    "seasons": [
        {
            "id": 5,
            "label": "21/22",
            "type": "actual"
        },…
    ],
    "items": {
        "Profit/loss sheet": {
            "id": 1,
            "items": {
                "1": {
                    "1": {
                        "label": "Total operating revenue",
                        "style": "bold",
                        "item_slag": "total-operating-revenue",
                        "amounts": [
                            0,
                            57.92,…
                        ],
                        "actualStatus": "edit",
                        "currency": [
                            "gbp",
                            "gbp",…
                        ]
                    },…
               },…
            },…
        },…
    }
    "club": {
        "name": "Arsenal",
        "logo": "http://api.asf.test/storage/logo/sport-clubs/arsenal.png"
    }
}
 */

use App\Containers\AppSection\Financial\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('financials/{club_id?}', [Controller::class, 'getUserFinancials'])
    ->name('api_financial_get_all_financials')
    ->middleware(['auth:api']);

