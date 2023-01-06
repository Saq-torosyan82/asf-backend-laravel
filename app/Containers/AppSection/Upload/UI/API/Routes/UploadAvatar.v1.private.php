<?php

/**
 * @apiGroup           Upload
 * @apiName            uploadAvatar
 *
 * @api                {POST} /v1/upload/avatar Upload avatar
 * @apiDescription     Upload avatar
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  user_id User id
 * @apiParam           {File}  avatar
 * @apiParam           {File}  [agent_avatar]
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  data: {
     id: ''
 }
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('upload/avatar', [Controller::class, 'uploadAvatar'])
    ->name('api_upload_upload_avatar')
    ->middleware(['auth:api']);

