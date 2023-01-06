<?php

/**
 * @apiGroup           Payment
 * @apiName            paymentConfirmation
 *
 * @api                {GET} /v1/confirm-payment Confirm payment
 * @apiDescription     Confirm payment
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  payment Payment id
 * @apiParam           {Int}  confirm  1 is confirmed and 0 is not confirmed
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
    Payment Collection "app/Containers/AppSection/Payment/Models/Payment.php"
 */

use App\Containers\AppSection\Payment\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('confirm-payment', [Controller::class, 'confirmPayment'])
    ->name('api_payment_payment_confirmation');

