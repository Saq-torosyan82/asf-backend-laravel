<?php

/**
 * @apiGroup           UserProfile
 * @apiName            SaveUserNewsSports
 *
 * @api                {POST} /v1/me/news/sports Save News Sports
 * @apiDescription     Save sports for news widget
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {Array}  sports Array of Sport ID's
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 [
    "NxOpZowo9GmjKqdR",
    "XbPW7awNkzl83LD6"
 ]
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('me/news/sports', [Controller::class, 'SaveNewsSports'])
    ->name('api_userprofile_save_news_sport')
    ->middleware(['auth:api']);

