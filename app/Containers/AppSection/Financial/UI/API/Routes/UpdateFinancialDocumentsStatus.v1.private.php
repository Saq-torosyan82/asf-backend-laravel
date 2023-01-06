<?php

/**
 * @apiGroup           Financial
 * @apiName            updateUserFinancialDocumentsStatus
 *
 * @api                {GET} /v1/financials/documents/status Update Financial Document Status
 * @apiDescription     Update User's Financial Document Status
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin
 *
 * @apiParam           {Boolean}  is_approved If the admin approved documents the `is_approved` parameter will be true
 * @apiParam           {Boolean}  is_rejected If the admin approved documents the `is_rejected` parameter will be true
 * @apiParam           {String}   reason The reason of rejection
 * @apiParam           {String}   Financial sheet
 * @apiParam           {String}   user_id user ID
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 204 OK
   No Content
 */

use App\Containers\AppSection\Financial\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('financials/documents/status', [Controller::class, 'updateFinancialDocumentsStatus'])
    ->name('api_financial_post_financial_documents_status')
    ->middleware(['auth:api']);

