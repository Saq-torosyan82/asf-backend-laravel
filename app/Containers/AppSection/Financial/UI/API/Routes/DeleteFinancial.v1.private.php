<?php

/**
 * @apiGroup           Financial
 * @apiName            deleteFinancial
 *
 * @api                {DELETE} /v1/financials/:id Delete Financial
 * @apiDescription     Delete financial by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  Success-Response:
 * HTTP/1.1 204 OK
   No Content
 */

use App\Containers\AppSection\Financial\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('financials/{id}', [Controller::class, 'deleteFinancial'])
    ->name('api_financial_delete_financial')
    ->middleware(['auth:api']);

