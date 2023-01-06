<?php

/**
 * @apiGroup           UserProfile
 * @apiName            GetBasicUserInfo
 *
 * @api                {GET} /v1/me Get basic user info
 * @apiDescription     Get logged user info
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": {
    "id": "8vExjAGZl3wLbmNP",
    "email": "test53@tripto.ro",
    "first_name": "First53",
    "last_name": "Last53",
    "user_type": "borrower",
    "borrower_type": "corporate"
    },
    "meta": {
    "include": [],
    "custom": []
    }
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me', [Controller::class, 'GetBasicUserInfo'])
    ->name('api_userprofile_get_basic_user_info')
    ->middleware(['auth:api']);

