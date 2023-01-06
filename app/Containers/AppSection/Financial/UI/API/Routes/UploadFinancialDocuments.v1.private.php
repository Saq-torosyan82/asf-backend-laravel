<?php

/**
 * @apiGroup           Financial
 * @apiName            uploadFinancialDocuments
 *
 * @api                {POST} /v1/financials/documents Upload Financial Documents
 * @apiDescription     Upload documents for financials
 *
 * @apiVersion         1.0.0
 * @apiPermission      Corporate User
 *
 * @apiParam           {Number}  section_id Financial section ID
 *
 * @apiParam        {File-Array}  files
 *
 * File or Array of Files
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 [
    "04nlJLGkyZw5MeAX",
    "doa7DZzEaDzJ5PYQ"
 ]
 */

use App\Containers\AppSection\Financial\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('financials/documents', [Controller::class, 'uploadFinancialDocuments'])
    ->name('api_financial_upload_financial_documents')
    ->middleware(['auth:api']);

