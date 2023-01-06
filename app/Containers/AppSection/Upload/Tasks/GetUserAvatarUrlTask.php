<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\UserProfile\Tasks\GetUserAvatarTask;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetUserAvatarUrlTask extends Task
{
    public function run(int $userId)
    {
        try {
            // check if user has avatar
            $avatar_id = app(GetUserAvatarTask::class)->run($userId);
            if (is_null($avatar_id)) {
                return '';
            }

            $upload = app(FindUploadByIdTask::class)->run($avatar_id);
            if (!$upload) {
                return '';
            }
        } catch (Exception $e) {
            /// silently ignore
            return '';
        }

        return downloadUrl($upload->uuid);
    }
}
