<?php

/**
 * @apiGroup           Upload
 * @apiName            deleteUpload
 *
 * @api                {DELETE} /v1/uploads/:id Delete upload
 * @apiDescription     Delete upload
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String} id Upload id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('uploads/{id}', [Controller::class, 'deleteUpload'])
    ->name('api_upload_delete_upload')
    ->middleware(['auth:api']);

