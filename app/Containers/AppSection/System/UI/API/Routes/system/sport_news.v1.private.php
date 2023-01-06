<?php

/**
 * @apiGroup           System
 * @apiName            GetSportNews
 *
 * @api                {GET} /v1/system/sport-news Get sport news
 * @apiDescription     This endpoint is used to get sport news. If the `sports` or `countries` (or both of them) is sent, the filtered data are returned, otherwise are returned all news.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {Array}  [sports] Sport ID or Array of Sport ID's
 *
 * @apiParam           {Array}  [countries] Country ID or Array of Country ID's
 *
 * @apiSuccessExample  {json}  Success-Response:
 *
 * HTTP/1.1 200 OK
{
    "current_page": 1,
    "data": [
        {
            "id": 237,
            "title": "Marcus Rashford: Man Utd forward must 'take steps' to reclaim his confidence, says Ralf Rangnick",
            "info": "It is up to misfiring Man Utd striker Marcus Rashford to recapture his best form in front of goal,…",
            "image": "https://e0.365dm.com/22/03/768x432/skysports-marcus-rashford-man-utd_5720750.jpg?20220327122700",
            "link": "https://www.skysports.com/football/news/11667/12582016/marcus-rashford-man-utd-forward-must-take-steps-to-reclaim-his-confidence-says-ralf-rangnick",
            "news_date": "2022-04-04 10:12:00",
            "country_id": null,
            "sport_id": 1,
            "created_at": "2022-04-04T09:15:11.000000Z",
            "updated_at": "2022-04-04T09:15:11.000000Z"
        },
        {
            "id": 235,
            "title": "Conor Gallagher is shining for Crystal Palace and England but Patrick Vieira believes he can get even better",
            "info": "Patrick Vieira knew Conor Gallagher was good. But not this good …",
            "image": "https://e0.365dm.com/22/03/768x432/skysports-palace-crystal_5722370.png?20220329085936",
            "link": "https://www.skysports.com/football/news/11095/12576972/conor-gallagher-is-shining-for-crystal-palace-and-england-but-patrick-vieira-believes-he-can-get-even-better",
            "news_date": "2022-04-04 10:05:00",
            "country_id": null,
            "sport_id": 1,
            "created_at": "2022-04-04T09:10:44.000000Z",
            "updated_at": "2022-04-04T09:10:44.000000Z"
        }
    ],
    "first_page_url": "http://api.asf.test/v1/system/sport-news?sports=NxOpZowo9GmjKqdR&countries=doa7DZzEqWzJ5PYQ&page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://api.asf.test/v1/system/sport-news?sports=NxOpZowo9GmjKqdR&countries=doa7DZzEqWzJ5PYQ&page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://api.asf.test/v1/system/sport-news?sports=NxOpZowo9GmjKqdR&countries=doa7DZzEqWzJ5PYQ&page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http://api.asf.test/v1/system/sport-news",
    "per_page": "10",
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('system/sport-news', [Controller::class, 'GetSportNews'])
    ->name('api_system_get_sport_news')
    ->middleware(['auth:api']);
