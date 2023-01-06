<?php

/**
 * @apiGroup           System
 * @apiName            api_system_get_all_lender_criteria
 *
 * @api                {GET} /v1/system/lender-criteria Get lender criteria
 * @apiDescription     Getting lender criteria ordered by type column and index column
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "currency": [
        {
        "id": "KJqn4Z26Owdlv6MB",
        "name": "eur"
        },
       ...
        ],
    "deal_type": [
        {
        "id": "39n0Z12OZGKERJgW",
        "name": "Player Transfer"
        },
     * .....

    ],
    "interest_range": [
        {
        "id": "8p6aY5zx7w9P3keO",
        "name": "2-4"
        },
         * ....
    ],
    "lender_type": [
        {
        "id": "NxOpZowo9GmjKqdR",
        "name": "Bank"
        },
     * ....
    ],
    "max_amount": [
        {
        "id": "5k68WRze9z1qVgeK",
        "name": "5m"
        },
     * ...
    ],
    "max_tenor": [
        {
        "id": "VxZM0JzbJzXrpdk5",
        "name": "2 years"
        },
     * ...
    ],
    "min_amount": [
        {
        "id": "1gdjp4zmbGl6Q9Rx",
        "name": "250.000k-5m"
        },
     * ...
    ],
    "min_interest": [
        {
        "id": "7VgmkMw7R2pWO5ja",
        "name": "2"
        },
     * ...
    ],
    "min_tenor": [
        {
        "id": "NqeELPGl8GmVOM7Z",
        "name": "3 months"
        },
         * ...
    ]
}
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('system/lender-criteria', [Controller::class, 'getAllLenderCriteria'])
    ->name('api_system_get_all_lender_criteria')
    ->middleware(['auth:api']);

