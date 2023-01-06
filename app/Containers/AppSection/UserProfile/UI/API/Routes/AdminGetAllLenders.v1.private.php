<?php

/**
 * @apiGroup           UserProfile
 * @apiName            getAllLenders
 *
 * @api                {GET} /v1/admin/lenders Get All Lenders
 * @apiDescription     Get list of all lenders
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin
 *
 * @apiParam           {String} [selected_currency] If the selected_currency parameter is sent, the deal values are presented according to that currency, otherwise the values are presented in the default currency (in GBP).
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
        "id": "doa7DZzEqWzJ5PYQ",
        "name": "First101 Last101",
        "avatar": "http://api.asf.test/v1/download/89b3771f-41be-49c4-90e6-4a2637b43cf0",
        "type": "Family Office",
        "country": "Romania",
        "started_deals": 3,
        "terms_accepted": 3,
        "success_rate": 1,
        "currency": "GBP",
        "amount": "5,477,443.00",
        "outstanding": "5,477,443.00",
        "deals": [
            {
                "deal_id": "ae8654wnLkGE9OnY",
                "currency": "GBP",
                "contract_amount": "677,443.00",
                "payment": "0.00",
                "outstanding": "677,443.00",
                "start_date": "2022-03-02T00:00:00.000000Z",
                "finish_date": "2025-05-02",
                "status": "live",
                "borrower": "Nume CinciDoi",
                "lender": "First101 Last101",
                "counterparty": {
                    "name": "Betano",
                    "avatar": "https://api.asf.stage.nextus.ro/storage/logo/sport-sponsors/betano.png"
                },
                "reason": "terms_uploaded",
                "reason_label": "Term Sheets uploaded",
                "status_bar": {
                    "percentaje": 70,
                    "label": "Term Sheets uploaded"
                },
                "nb_installments": 4,
                "paid_installments": 0
            },…
        ]
    },…
]
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('admin/lenders', [Controller::class, 'getAllLenders'])
    ->name('api_userprofile_admin_get_all_lenders')
    ->middleware(['auth:api']);

