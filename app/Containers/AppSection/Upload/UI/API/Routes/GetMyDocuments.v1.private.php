<?php

/**
 * @apiGroup           Upload
 * @apiName            GetMyDocuments
 *
 * @api                {GET} /v1/me/documents Get authenticated user documents
 * @apiDescription     Get authenticated user documents
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "personal": [
        {
        "label": "Termsheet Deal",
        "borrower_name": "Test CinciDoi",
        "status": "accepted",
        "url": "http://api.apiato.test/v1/download/599fa1e0-7a0d-454a-90e9-6fbc2a04b6d3",
        "file_type": "application/pdf",
        "file_name": "12_1641537329.pdf",
        "file_size": 1684398
        }
    ],
    "deals": [
        {
        "id": "jM7L5PzYA8zOJdrl",
        "label": "Contract Deal",
        "borrower_name": "Test CinciDoi",
        "url": "http://api.apiato.test/v1/download/86a606f7-b079-4254-bfd3-0a89f7d15274",
        "file_type": "application/pdf",
        "file_name": "Gantt Chart 24th January till 4th February_1643044422.pdf",
        "file_size": 121781
        }
    ]
}
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/documents', [Controller::class, 'GetMyDocuments'])
    ->name('api_upload_get_my_documents')
    ->middleware(['auth:api']);

