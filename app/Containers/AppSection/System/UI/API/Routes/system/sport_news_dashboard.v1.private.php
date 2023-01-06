<?php

/**
 * @apiGroup           System
 * @apiName            GetSportNewsForWidget
 *
 * @api                {GET} /v1/dashboard/sport-news Get sport news for widget
 * @apiDescription     This endpoint is used to get sport news for news widget. On Dashboard should be presented the newest news by default, until user doesn't define in User profile for which sport/country is interested in to see news on Dashboard. Count of showing news is defined in the `appSection-system.php` file.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 * @apiSuccessExample  {json}  Success-Response:
 *
 * HTTP/1.1 200 OK
[
    {
        "id": 215,
        "title": "Claressa Shields says Savannah Marshall's knockout power will not be enough in their undisputed title clash",
        "info": "Claressa Shields says Savannah Marshall's power is not enough to defeat her,…",
        "image": null,
        "link": "https://www.skysports.com/boxing/news/30778/12581142/claressa-shields-says-savannah-marshalls-knockout-power-will-not-be-enough-in-their-undisputed-title-clash",
        "news_date": "2022-04-03 16:54:00",
        "country_id": null,
        "sport_id": 18,
        "created_at": "2022-04-04T08:58:35.000000Z",
        "updated_at": "2022-04-04T08:58:35.000000Z"
    },
    {
        "id": 216,
        "title": "Savannah Marshall demolished Femke Hermans to set up an undisputed clash with Claressa Shields",
        "info": "Savannah Marshall inflicted a crushing knockout on Femke Hermans to set up an …",
        "link": "https://www.skysports.com/boxing/news/12183/12580836/savannah-marshall-demolished-femke-hermans-to-set-up-an-undisputed-clash-with-claressa-shields",
        "news_date": "2022-04-03 09:12:00",
        "country_id": null,
        "sport_id": 18,
        "created_at": "2022-04-04T08:58:36.000000Z",
        "updated_at": "2022-04-04T08:58:36.000000Z"
    },…
]
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('dashboard/sport-news', [Controller::class, 'GetSportNewsDashboard'])
    ->name('api_system_get_sport_news')
    ->middleware(['auth:api']);
