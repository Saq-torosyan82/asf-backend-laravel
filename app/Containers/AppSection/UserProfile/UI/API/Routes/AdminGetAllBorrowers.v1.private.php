<?php

/**
 * @apiGroup           UserProfile
 * @apiName            getAllBorrowers
 *
 * @api                {GET} /v1/admin/borrowers Get All Borrowers
 * @apiDescription     Get list of all borrowers
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin
 *
 * @apiParam           {String}  [selected_currency] If the selected_currency parameter is sent, the deal values are presented according to that currency, otherwise the values are presented in the default currency (in GBP).
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
        "id": "NxOpZowo99GmjKqd",
        "name": "Test CinciDoi",
        "mode": "athlete",
        "type": "Professional Athlete",
        "country": "England",
        "sport": "Football",
        "started_deals": 34,
        "currency": "GBP",
        "contract_amount": "199,714,144.20",
        "outstanding": "199,714,144.20",
        "deals": [
            {
                "deal_id": "p6ELeYGQ9XGZ1PjW",
                "currency": "GBP",
                "contract_amount": "1,999,900.00",
                "payment": "0.00",
                "outstanding": "1,999,900.00",
                "start_date": "2022-01-12T00:00:00.000000Z",
                "finish_date": "2026-12-16",
                "status": "started",
                "borrower": "Test CinciDoi",
                "lender": "",
                "counterparty": {
                    "name": "Luluemon athletica",
                    "avatar": "https://api.asf.stage.nextus.ro/storage/logo/sport-brands/lululemon-athletica.png"
                },
                "reason": "contract_signed",
                "reason_label": "Contract signed by both parties",
                "status_bar": {
                    "percentaje": 100,
                    "label": "Contract signed by both parties"
                },
                "nb_installments": 5,
                "paid_installments": 0
            },…
        ],
    },…
]
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('admin/borrowers', [Controller::class, 'getAllBorrowers'])
    ->name('api_userprofile_admin_get_all_borrowers')
    ->middleware(['auth:api']);

