<?php

/**
 * @apiGroup           UserProfile
 * @apiName            GetUserNewsCountries
 *
 * @api                {GET} /v1/me/news/countries Get User's News Countries
 * @apiDescription     Get all countries saved by the user for news part
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
        "id": "AKxY1RwjQE2EN40r",
        "name": "England"
    },
    {
        "id": "OaPvk1z45GN6Yd3M",
        "name": "Belgium"
]
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/news/countries', [Controller::class, 'GetNewsCountries'])
    ->name('api_userprofile_get_news_countries')
    ->middleware(['auth:api']);