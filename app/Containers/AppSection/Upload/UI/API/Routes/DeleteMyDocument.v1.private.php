<?php

/**
 * @apiGroup           Upload
 * @apiName            DeleteMyDocument
 *
 * @api                {DELETE} /v1/me/documents/:uuid Delete document
 * @apiDescription     Delete document
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  uuid Document uuid
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('me/documents/{uuid}', [Controller::class, 'DeleteMyDocument'])
    ->name('api_upload_delete_my_document')
    ->middleware(['auth:api']);

