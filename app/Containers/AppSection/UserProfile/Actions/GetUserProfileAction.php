<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByUserIdTask;
use App\Ship\Parents\Actions\Action;

class GetUserProfileAction extends Action
{
    public function run($user_id)
    {
        return app(FindUserProfileByUserIdTask::class)->addRequestCriteria()->run($user_id);
    }
}
