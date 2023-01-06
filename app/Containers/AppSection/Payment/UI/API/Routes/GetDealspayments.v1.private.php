<?php

/**
 * @apiGroup           Payment
 * @apiName            getDealsPayments
 *
 * @api                {GET} /v1/total-deal-payments Get Total Deal Payments
 * @apiDescription     Get total deal payments
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {String}  [selected_currency] If the selected_currency parameter is sent, the amounts are presented according to that currency, otherwise the values are presented in the default currency (in GBP).
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "all": {
        "data": [
            {
                "date": "2022-01-05",
                "borrower": "Test CinciDoi",
                "borrower_type": "Professional Athlete",
                "lender": "First101 Last101",
                "lender_type": "Family Office",
                "currency": "GBP",
                "deal_value": "1,999,900.00",
                "payments": "0.00",
                "outstanding": "1,999,900.00",
                "installments": 5,
                "paid_installments": 0
            },…
        ],
        "totalDealValue": "2,999,900.00",
        "totalPayments": "0.00",
        "totalOutstanding": "2,999,900.00"
    },
    "overdue": {
        "data": [
            {
                "date": "2022-02-02",
                "overdue": 11,
                "borrower": "Nume CinciDoi",
                "lender": "First101 Last101",
                "currency": "GBP",
                "deal_value": 3682427.46,
                "payments": 3682.43,
                "installments": 5,
                "paid_installments": 3
            },…
        ],
        "totalDealValue": 4682427.46,
        "totalPayments": 8682.43
    }
}
 */

use App\Containers\AppSection\Payment\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('admin/total-deal-payments', [Controller::class, 'getDealsPayments'])
    ->name('api_payment_get_deal_payments')
    ->middleware(['auth:api']);

