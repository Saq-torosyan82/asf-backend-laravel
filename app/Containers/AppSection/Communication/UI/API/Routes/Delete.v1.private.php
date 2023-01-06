<?php

/**
 * @apiGroup           Communication
 * @apiName            deleteCommunication
 *
 * @api                {DELETE} /v1/communications/:id Delete Communication
 * @apiDescription     Delete communication by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 204 OK
 No Content
 */

use App\Containers\AppSection\Communication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('communications/{id}', [Controller::class, 'delete'])
    ->name('api_communication_delete_communication')
    ->middleware(['auth:api']);

