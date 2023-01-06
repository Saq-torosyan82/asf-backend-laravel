<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tasks\GetChildUsersByParentIdTask;
use App\Containers\AppSection\User\Tasks\GetUsersByIdsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAthletesAction extends Action
{
    public function run(Request $request)
    {
        $crtUser = $request->user();
        $usersIds = [];

        if ($crtUser->isIndependentAgent() || $crtUser->isAgency()) {
            $agentIds = $crtUser->childs()->pluck('id')->toArray();
            $agentIds[] = $crtUser->id;
            $usersIds = [];
            foreach ($agentIds as $agent_id) {
                $user = app(FindUserByIdTask::class)->run($agent_id);
                $usersIds = array_merge($usersIds, $user->athletes()->pluck('id')->toArray());
            }

        } elseif ($crtUser->isAdmin() && $request->has('user_id')) {
            $usersIds[] = $request->user_id;
        } else {
            // throw exception
        }

        return app(GetUsersByIdsTask::class)->run($usersIds);
    }
}
