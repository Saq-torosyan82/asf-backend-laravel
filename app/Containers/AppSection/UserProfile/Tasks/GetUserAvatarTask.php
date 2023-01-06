<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class GetUserAvatarTask extends Task
{
    public function run(int $user_id)
    {
        try {
            $res = app(FindUserProfileFieldTask::class)->run($user_id, Group::USER, Key::AVATAR);
            if ($res) {
                return $res->value;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }
}
