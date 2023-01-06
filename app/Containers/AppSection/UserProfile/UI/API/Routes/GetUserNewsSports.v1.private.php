<?php

/**
 * @apiGroup           UserProfile
 * @apiName            GetUserNewsSports
 *
 * @api                {GET} /v1/me/news/sports Get User's News Sports
 * @apiDescription     Get all sports saved by the user for news part
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
        "id": "NxOpZowo9GmjKqdR",
        "name": "Football"
    },
    {
        "id": "XbPW7awNkzl83LD6",
        "name": "Rugby League"
    }
]
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/news/sports', [Controller::class, 'GetNewsSports'])
    ->name('api_userprofile_get_news_sports')
    ->middleware(['auth:api']);