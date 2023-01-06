<?php

/**
 * @apiGroup           UserProfile
 * @apiName            SaveUserNewsCountries
 *
 * @api                {POST} /v1/me/news/countries Save News Countries
 * @apiDescription     Save countries for news widget
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {Array}  countries Array of Country ID's
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

Route::post('me/news/countries', [Controller::class, 'SaveNewsCountries'])
    ->name('api_userprofile_save_news_country')
    ->middleware(['auth:api']);

