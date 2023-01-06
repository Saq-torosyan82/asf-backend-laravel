<?php

/**
 * @apiGroup           Deal
 * @apiName            GetDetailDeal
 *
 * @api                {GET} /v1/deals/:id Get deal detail by id
 * @apiDescription     Get deal detail by id
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Deal id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": {
    "id": "Pgb2JMQjOW0qXVybaGwro71xpLmYlRvE",
    "user_id": 228,
    "deal_type": "live",
    "contract_type": "endorsement",
    "status": "in_progress",
    "status_label": "In progress",
    "reason": "submitted",
    "reason_label": "Application submitted",
    "currency": "GBP",
    "contract_amount": 19015880,
    "upfront_amount": 0,
    "interest_rate": 7,
    "gross_amount": 20000000,
    "deal_amount": 20470678,
    "first_installment": "2022-09-02T00:00:00.000000Z",
    "frequency": "quarterly",
    "nb_installmetnts": 5,
    "funding_date": "2022-05-19T00:00:00.000000Z",
    "criteria_data": {
    "club": null,
    "league": null,
    "athlete": null,
    "tvHolder": null,
    "club_type": null,
    "user_type": null,
    "contract_type": "endorsement",
    "sponsorOrBrand": {
    "id": "PW7Dmr6ovN8b23na1n0qzZLBjMXOa1lA",
    "logo": "https://api.asf.nextus.ro/storage/logo/sport-sponsors/chevrolet.png",
    "name": "Chevrolet"
    },
    "sponsorsOrBrandsIdentifier": "sponsors"
    },
    "payments_data": [
    {
    "index": 1,
    "grossAmount": 4000000,
    "paymentDate": "2022-09-02T06:54:00.000Z",
    "paymentAmount": 3675618,
    "interestPeriod": "0.3",
    "interestCharged": [],
    "interestPeriodMonths": 4
    },
    {
    "index": 2,
    "grossAmount": 4000000,
    "paymentDate": "2022-12-02T07:54:00.000Z",
    "paymentAmount": 3738318,
    "interestPeriod": "0.5",
    "interestCharged": [],
    "interestPeriodMonths": 7
    },
    {
    "index": 3,
    "grossAmount": 4000000,
    "paymentDate": "2023-03-02T07:54:00.000Z",
    "paymentAmount": 3802088,
    "interestPeriod": "0.8",
    "interestCharged": [],
    "interestPeriodMonths": 10
    },
    {
    "index": 4,
    "grossAmount": 4000000,
    "paymentDate": "2023-06-02T06:54:00.000Z",
    "paymentAmount": 3866946,
    "interestPeriod": "1.0",
    "interestCharged": [],
    "interestPeriodMonths": 13
    },
    {
    "index": 5,
    "grossAmount": 4000000,
    "paymentDate": "2023-09-02T06:54:00.000Z",
    "paymentAmount": 3932910,
    "interestPeriod": "1.3",
    "interestCharged": [],
    "interestPeriodMonths": 16
    }
    ],
    "fees_data": {
    "costs": "60000.300",
    "legalCost": 60000,
    "insuranceExpense": 0
    },
    "user_documents": [
    {
    "type": "id",
    "label": "ID",
    "is_multiple": false,
    "id": "JKvAXzk8gxQZ7ByGJvw9LG3R4m0Yjloa",
    "url": "https://api.asf.nextus.ro/v1/download/3f4837c7-c28d-4e81-947b-48ec2b64b503",
    "is_verified": 0,
    "upload_date": "2022-05-06"
    },
    {
    "type": "contract",
    "label": "Copy of the signed contract governing the receivable",
    "is_multiple": false,
    "id": "PW7Dmr6ovN8b23na11n0qzZLBjMXOa1l",
    "url": "https://api.asf.nextus.ro/v1/download/a0b383cb-5e16-4043-957e-b45e2ddcb0f9",
    "is_verified": 0,
    "upload_date": "2022-05-06"
    },
    {
    "type": "proof_of_address",
    "label": "Proof of address",
    "is_multiple": false,
    "id": "kLXNMp56eV20PJnkB3ygZ7zB3qGlmA1a",
    "url": "https://api.asf.nextus.ro/v1/download/ac359c60-6ae9-40af-87a7-a24f49c677af",
    "is_verified": 0,
    "upload_date": "2022-05-06"
    },
    {
    "type": "company_incorporation",
    "label": "Company Incorporation Document",
    "is_multiple": false,
    "id": "zKk6P7lWD2ABeRwDNVnEr8obgmN4pYjJ",
    "url": "https://api.asf.nextus.ro/v1/download/a4e89003-dcd0-4eba-996d-6710cc71acab",
    "is_verified": 0,
    "upload_date": "2022-05-06"
    },
    {
    "type": "other_suporting_information",
    "label": "Any other Supporting Information",
    "is_multiple": true,
    "id": "ELkOxj9vqobQeZnVoWd6JAmDa32P4VKX",
    "url": "https://api.asf.nextus.ro/v1/download/e4f6363e-f1e9-4d1f-b03d-d0eef2f089c3",
    "is_verified": 0,
    "upload_date": "2022-05-06"
    },
    {
    "type": "agent_representation_agreement",
    "label": "Agent Representation agreement",
    "is_multiple": false,
    "id": "YG1mAO26eL574Kd9JQwjqDER9XJlWPNb",
    "url": "https://api.asf.nextus.ro/v1/download/1695b5d3-52f4-43e2-8065-d718e6a1c97a",
    "is_verified": 0,
    "upload_date": "2022-05-06"
    },
    {
    "type": "sports_marketing_representation_agreement",
    "label": "Sports Marketing Rep Contract",
    "is_multiple": false,
    "id": "Pgb2JMQjOW0qXVyb3anro71xpLmYlRvE",
    "url": "https://api.asf.nextus.ro/v1/download/d67dc377-d80f-404b-805e-f3311d4c36f5",
    "is_verified": 0,
    "upload_date": "2022-05-06"
    },
    {
    "type": "credit_analysis",
    "label": "Credit Analysis",
    "is_multiple": false,
    "id": "WV9gNzjeopJQXkwY5DwMZ4lO1mxDKALb",
    "url": "https://api.asf.nextus.ro/v1/download/081f4f36-bfcb-4d21-ad7a-f869644a09d0",
    "is_verified": 1,
    "upload_date": "2022-05-06 06:57:18"
    }
    ],
    "consent_data": {
    "sellerAgreement": true,
    "shownToFinancier": false,
    "informedIntention": true,
    "confirmNoExclusivity": true,
    "confirmUsageOfDocuments": true
    },
    "contact_data": [
    {
    "email": "dsfsdfgds@dsafasda.ro",
    "phone": "43523452",
    "lastName": "fvxcvxc",
    "position": "vbxcvbxcv",
    "firstName": "dfvsfvsd"
    }
    ],
    "contract_data": {
    "net_amount": "20000000.00",
    "has_borrowed": false,
    "contract_date": "2022-05-01T06:54:00.000Z",
    "contract_value": "20000000.00",
    "guaranteed_amount": "0",
    "guaranteed_contract": "1"
    },
    "status_bar": {
    "percentaje": 30,
    "label": "Application submitted"
    },
    "type_label": "Endorsement",
    "borrower": {
    "name": "First53 Last53",
    "avatar": ""
    },
    "counterparty": {
    "name": "Chevrolet",
    "avatar": "https://api.asf.nextus.ro/storage/logo/sport-sponsors/chevrolet.png"
    },
    "lender": {
    "name": "",
    "avatar": ""
    },
    "paid_back": 0,
    "next_payment": {
    "status": "Pending",
    "amount": 4000000,
    "payment_date": "2022-09-02",
    "crt_installment": 1,
    "nb_installments": 5
    },
    "offers": []
    },
    "meta": {
    "include": [],
    "custom": []
    }
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('deals/{id}', [Controller::class, 'GetDetailDeal'])
    ->name('api_deal_get_detail_deal')
    ->middleware(['auth:api']);

