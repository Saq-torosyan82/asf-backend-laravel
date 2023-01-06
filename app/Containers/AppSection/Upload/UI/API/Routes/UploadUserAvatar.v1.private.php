<?php

/**
 * @apiGroup           Upload
 * @apiName            uploadUserAvatar
 *
 * @api                {POST} /v1/users/:user_id/avatar Upload user avatar
 * @apiDescription     Upload user avatar
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
    data:{
        id: ''
    }
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('/users/{user_id}/avatar', [Controller::class, 'UploadUserAvatar'])
    ->name('api_upload_')
    ->middleware(['auth:api']);

