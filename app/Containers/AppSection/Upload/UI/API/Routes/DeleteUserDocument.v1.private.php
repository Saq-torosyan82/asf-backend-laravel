<?php

/**
 * @apiGroup           Upload
 * @apiName            DeleteUserDocument
 *
 * @api                {DELETE} /v1/users/:user_id/documents/:uuid Delete user document
 * @apiDescription     Delete user document
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  user_id User id
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

Route::delete('users/{user_id}/documents/{uuid}', [Controller::class, 'DeleteUserDocument'])
    ->name('api_upload_delete_user_document')
    ->middleware(['auth:api']);

