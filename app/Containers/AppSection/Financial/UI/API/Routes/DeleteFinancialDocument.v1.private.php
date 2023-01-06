<?php

/**
 * @apiGroup           Financial
 * @apiName            deleteFinancialDocument
 *
 * @api                {DELETE} /v1/financials/:id Delete Financial Document
 * @apiDescription     Delete financial document by id
 *
 * @apiVersion         1.0.0
 * @apiPermission      Corporate User, Admin User
 *
 * @apiSuccessExample  Success-Response:
 * HTTP/1.1 204 OK
No Content
 */

use App\Containers\AppSection\Financial\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('financials/documents/{id}', [Controller::class, 'deleteFinancialDocument'])
    ->name('api_financial_delete_financial_document')
    ->middleware(['auth:api']);

