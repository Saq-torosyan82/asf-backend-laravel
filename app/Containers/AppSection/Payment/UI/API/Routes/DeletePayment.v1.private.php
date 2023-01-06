<?php

/**
 * @apiGroup           Payment
 * @apiName            deletePayment
 *
 * @api                {DELETE} /v1/payments/:id Delete payment
 * @apiDescription     Delete payment
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

Route::delete('payments/{id}', [Controller::class, 'deletePayment'])
    ->name('api_payment_delete_payment')
    ->middleware(['auth:api']);

