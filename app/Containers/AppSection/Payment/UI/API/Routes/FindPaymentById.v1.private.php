<?php

/**
 * @apiGroup           Payment
 * @apiName            findPaymentById
 *
 * @api                {GET} /v1/payments/:id Get payment by id
 * @apiDescription     Get payment by id
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Payment id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    data: {
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
}
 */

use App\Containers\AppSection\Payment\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('payments/{id}', [Controller::class, 'findPaymentById'])
    ->name('api_payment_find_payment_by_id')
    ->middleware(['auth:api']);

