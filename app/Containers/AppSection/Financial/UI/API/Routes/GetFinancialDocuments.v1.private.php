<?php

/**
 * @apiGroup           Financial
 * @apiName            getUserFinancialDocuments
 *
 * @api                {GET} /v1/financials/documents/files/:club_id? Get User Financial Documents
 * @apiDescription     This endpoint is used to get all financial documents of sport organizations. If the authenticated user is a corporate user, the club_id will be fetched automatically, otherwise the club_id must be sent.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin or Corporate User
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "Profit/loss sheet": {
        "label": "Profit/loss sheet",
        "items": [
            {
                "id": "YJ5evQ20bEzx68dK",
                "user_id": "XbPW7awNLkGl83LD",
                "name": "final_project.xlsx",
                "upload_date": "2022-05-17",
                "upload_id": "XOKlq3GKnPzA1PWJ",
                "status": 2,
                "status_label": "Verified",
                "url": "http://api.asf.test/v1/download/47e3fd15-c8d3-49b2-999a-ca55ae9e0aaf"
            },
            {
                "id": "ae8654wn5e2E9OnY",
                "user_id": "XbPW7awNLkGl83LD",
                "name": "05.pdf",
                "upload_date": "2022-05-15",
                "upload_id": "AKxY1RwjdVGEN40r",
                "status": 2,
                "status_label": "Verified",
                "url": "http://api.asf.test/v1/download/566cb36c-069b-4dc1-817c-ab77be20f6c0"
            },…
        ]
    },…
}
 */

use App\Containers\AppSection\Financial\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('financials/documents/files/{club_id?}', [Controller::class, 'getUserFinancialDocuments'])
    ->name('api_financial_get_financial_documents')
    ->middleware(['auth:api']);

