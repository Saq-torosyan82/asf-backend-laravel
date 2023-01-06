<?php

/**
 * @apiGroup           Communication
 * @apiName            getQuestionTypes
 *
 * @api                {GET} /v1/communications/questions Get All Types of Questions
 * @apiDescription     Get all types of questions for service type communication.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
        "id": 1,
        "name": "Technical issue"
    },
    {
        "id": 2,
        "name": "Information"
    },
    {
        "id": 3,
        "name": "Deal calculator"
    }
]
 */

use App\Containers\AppSection\Communication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('communications/service/questions', [Controller::class, 'getQuestionTypes'])
    ->name('api_communication_get_question_types')
    ->middleware(['auth:api']);

