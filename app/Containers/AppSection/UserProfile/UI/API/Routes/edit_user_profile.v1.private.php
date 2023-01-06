<?php

/**
 * @apiGroup           UserProfile
 * @apiName            EditUserProfile
 *
 * @api                {GET} /v1/users/{id}/profile Edit user profile
 * @apiDescription     Edit user profile
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Profile id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "account": {
    "borrower_mode_id": "PW7Dmr6ovN8b23na1n0qzZLBjMXOa1lA",
    "borrower_type": "athlete",
    "user_type": "borrower"
    },
    "address": {
    "city": "Chisinau",
    "country": "7aY5E9pN246kAMyR8zdrGV1xJljXmZeL",
    "state": "Chișinău",
    "street": "bd. Decebal 23/2, ap. 128",
    "zip": "2001"
    },
    "contact": {
    "phone": "+373 693 23 099"
    },
    "professional": {
    "club": "WV9gNzjeopJQXkwY9wMZ4lO1mxDKALbG",
    "country": "ZVL7mqE4QJDjlXnp57dYvWa9b51gMoGp",
    "league": "zlDm7v0a4NkBLJdjD2yx6G3X52EV1OeZ",
    "sport": "zKk6P7lWD2ABeRwDVnEr8obgmN4pYjJ0",
    "sport_txt": "Football"
    },
    "user": {
    "email": "test41@tripto.ro",
    "first_name": "Nicolae",
    "last_name": "Casir"
    }
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('users/{id}/profile', [Controller::class, 'EditUserProfile'])
    ->name('api_userprofile_edit_user_profile')
    ->middleware(['auth:api']);

