<?php

/**
 * @apiGroup           Payment
 * @apiName            createPayment
 *
 * @api                {POST} /v1/payments Create payment
 * @apiDescription     Create payment
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  deal_id Deal id
 * @apiParam           {String}  user_id User id
 * @apiParam           {String}  lender_id Lender id
 * @apiParam           {Float}  amount Amount of payment
 * @apiParam           {Int}  installment_nb Installment number
 * @apiParam           {Date}  date Date of payment
 * @apiParam           {Int}  [is_paid] Is payment is paid
 * @apiParam           {Date}  [paid_date] Date when payment was paid
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

Route::post('payments', [Controller::class, 'createPayment'])
    ->name('api_payment_create_payment')
    ->middleware(['auth:api']);

