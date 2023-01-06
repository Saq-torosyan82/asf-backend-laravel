<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Ship\Parents\Actions\Action;

class GetBasicUserInfoAction extends Action
{
    public function run()
    {
        return app(GetAuthenticatedUserTask::class)->run();
    }
}
