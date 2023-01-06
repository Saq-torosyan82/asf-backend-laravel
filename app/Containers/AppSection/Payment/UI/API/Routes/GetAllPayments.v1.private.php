<?php

/**
 * @apiGroup           Payment
 * @apiName            getAllPayments
 *
 * @api                {GET} /v1/payments Get all payments
 * @apiDescription     Get all payments
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    data: [
          {
            object : '',
            id : '',
            user_id : '',
            email : '',
            deal_id : '',
            deal : '',
            amount : '',
            date : '',
            is_paid : '',
            paid_date : '',
            extra_data : '',
        }
        ...
    ]
}
 */

use App\Containers\AppSection\Payment\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('payments', [Controller::class, 'getAllPayments'])
    ->name('api_payment_get_all_payments')
    ->middleware(['auth:api']);

