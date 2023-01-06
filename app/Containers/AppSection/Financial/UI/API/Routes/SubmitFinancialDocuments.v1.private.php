<?php

/**
 * @apiGroup           Financial
 * @apiName            submitFinancialDocuments
 *
 * @api                {POST} /v1/financials/submit-documents Submit Financial Documents
 * @apiDescription     Submit documents for financials
 *
 * @apiVersion         1.0.0
 * @apiPermission      Corporate User, Admin User
 *
 * @apiParam           {Number}  section_id Financial section ID
 *
 * @apiParam           {String}  club_id Club ID
 *
 * @apiParam        {File-Array}  files
 *
 * File or Array of Files
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    "0y7JAN2dyZwnavml",
    "LXpx3azMoB2PNdyM"
]
 */

use App\Containers\AppSection\Financial\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('financials/submit-documents', [Controller::class, 'submitFinancialDocuments'])
    ->name('api_financial_submit_financial_documents')
    ->middleware(['auth:api']);

