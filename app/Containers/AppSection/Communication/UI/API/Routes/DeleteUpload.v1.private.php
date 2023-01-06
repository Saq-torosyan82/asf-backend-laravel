<?php

/**
 * @apiGroup           Communication
 * @apiName            deleteAttachment
 *
 * @api                {DELETE} /v1/communications/attachements/:id Delete Attachment
 * @apiDescription     Delete attachment by ID
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

Route::delete('communications/attachements/{id}', [Controller::class, 'deleteAttachments'])
    ->name('api_communication_delete_attachements')
    ->middleware(['auth:api']);

