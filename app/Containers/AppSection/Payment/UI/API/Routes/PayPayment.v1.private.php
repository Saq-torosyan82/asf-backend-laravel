<?php

/**
 * @apiGroup           Payment
 * @apiName            PayPayment
 *
 * @api                {PATCH} /v1/payments/:id/pay Pay payment
 * @apiDescription     Pay payment
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Payment id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\Payment\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::patch('payments/{id}/pay', [Controller::class, 'payPayment'])
    ->name('api_payment_pay_payment')
    ->middleware(['auth:api']);

