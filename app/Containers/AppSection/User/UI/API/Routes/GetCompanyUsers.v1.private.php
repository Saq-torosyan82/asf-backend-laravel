<?php

/**
 * @apiGroup           User
 * @apiName            getCompanyUsers
 * @api                {get} /v1/company-users Get Company Users
 * @apiDescription     Get Company Users
 *
 * @apiVersion         1.0.0
 * @apiPermission      Corporate User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": [
        {
            "object": "User",
            "id": "0y7JAN2dbznavmld",
            "first_name": "Claudiu",
            "last_name": "Jalba",
            "email": "test40@tripto.ro",
            "email_verified_at": "2021-09-30T19:30:05.000000Z",
            "gender": null,
            "birth": null,
            "is_active": true,
            "avatar": "http://api.asf.test/v1/download/cbe5d1da-4409-4179-b8dd-f4cffe679c80",
            "created_at": "2021-09-23T20:30:00.000000Z",
            "updated_at": "2021-09-27T16:52:34.000000Z",
            "readable_created_at": "7 months ago",
            "readable_updated_at": "7 months ago"
        },
        {
            "object": "User",
            "id": "p6ELeYGQ9XGZ1PjW",
            "first_name": "fada",
            "last_name": "sdfasdfasdf",
            "email": "test64@tripto.ro",
            "email_verified_at": "2021-10-01T17:23:09.000000Z",
            "gender": null,
            "birth": null,
            "is_active": true,
            "avatar": "",
            "created_at": "2021-10-01T17:21:53.000000Z",
            "updated_at": "2021-10-07T16:26:23.000000Z",
            "readable_created_at": "7 months ago",
            "readable_updated_at": "7 months ago"
        }
    ],
    "meta": {
        "include": [
           "roles"
        ],
        "custom": []
    }
}
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('company-users', [Controller::class, 'getCompanyUsers'])
    ->name('api_user_get_company_users')
    ->middleware(['auth:api']);
