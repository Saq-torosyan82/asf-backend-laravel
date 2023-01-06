<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Models\UserProfile;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByUserIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetMyUserProfileAction extends Action
{
    public function run(Request $request)
    {
        return app(FindUserProfileByUserIdTask::class)->addRequestCriteria()->run($request->user()->id);
    }
}
