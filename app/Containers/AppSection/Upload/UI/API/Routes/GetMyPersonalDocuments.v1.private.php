<?php

/**
 * @apiGroup           Upload
 * @apiName            GetMyDocuments
 *
 * @api                {GET} /v1/me/documents Get personal documents
 * @apiDescription     Get personal documents
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  contract_type Contract types : player_transfer, endorsement, media_rights, player_advance, agent_fees
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    [
    {
    "type": "id",
    "label": "Club Owner/s ID (Driver License, Passport, or Visa)",
    "is_multiple": false,
    "id": "",
    "is_verified": 0,
    "url": "",
    "file_type": "",
    "file_name": "",
    "file_size": ""
    },
    {
    "type": "proof_of_address",
    "label": "Proof of address",
    "is_multiple": false,
    "id": "",
    "is_verified": 0,
    "url": "",
    "file_type": "",
    "file_name": "",
    "file_size": ""
    },
    {
    "type": "company_incorporation",
    "label": "Company Incorporation Document",
    "is_multiple": false,
    "id": "",
    "is_verified": 0,
    "url": "",
    "file_type": "",
    "file_name": "",
    "file_size": ""
    },
    {
    "type": "ownership_structure",
    "label": "Club Ownership Structure",
    "is_multiple": false,
    "id": "",
    "is_verified": 0,
    "url": "",
    "file_type": "",
    "file_name": "",
    "file_size": ""
    },
    {
    "type": "two_years_accounts",
    "label": "Copy of the last two years accounts (PDF Format)",
    "is_multiple": false,
    "id": "7b5892a8-fa27-46d4-bb52-9b69601c2a85",
    "is_verified": 2,
    "url": "http://api.apiato.test/v1/download/decda8ed-d5de-448b-8ee2-57ea8eb91fa9",
    "file_type": "image/png",
    "file_name": "What they want_1637785867.png",
    "file_size": 627691
    },
    {
    "type": "management_accounts_twelve_months",
    "label": "Copy of the existing management accounts for the last 12 months",
    "is_multiple": false,
    "id": "",
    "is_verified": 0,
    "url": "",
    "file_type": "",
    "file_name": "",
    "file_size": ""
    },
    {
    "type": "monthly_quarterly_projections",
    "label": "Monthly or Quarterly projections of balance sheets, income and cash flow statements",
    "is_multiple": false,
    "id": "",
    "is_verified": 0,
    "url": "",
    "file_type": "",
    "file_name": "",
    "file_size": ""
    },
    {
    "type": "list_of_payables",
    "label": "List of payables (Club Transfers)",
    "is_multiple": false,
    "id": "",
    "is_verified": 0,
    "url": "",
    "file_type": "",
    "file_name": "",
    "file_size": ""
    },
    {
    "type": "list_of_receivables",
    "label": "List of Receivables",
    "is_multiple": false,
    "id": "",
    "is_verified": 0,
    "url": "",
    "file_type": "",
    "file_name": "",
    "file_size": ""
    },
    {
    "type": "management_information",
    "label": "Management information since the last FY end on a monthly basis",
    "is_multiple": false,
    "id": "",
    "is_verified": 0,
    "url": "",
    "file_type": "",
    "file_name": "",
    "file_size": ""
    },
    {
    "type": "other_suporting_information",
    "label": "Any other Supporting Information",
    "is_multiple": true,
    "data": []
    }
]
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/documents/personal', [Controller::class, 'GetMyPersonalDocuments'])
    ->name('api_upload_get_my_personal_documents')
    ->middleware(['auth:api']);

