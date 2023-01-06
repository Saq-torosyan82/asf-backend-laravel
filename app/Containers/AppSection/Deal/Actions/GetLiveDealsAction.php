<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Tasks\GetAllDealsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetLiveDealsAction extends Action
{
    public function run(Request $request)
    {
        $user = $request->user();

        if ($user->hasAdminRole()) {
            return app(GetAllDealsTask::class)->addRequestCriteria(
                null,
                ['country_id', 'user_id', 'sport_id']
            )->ordered()->run();
        }

        if ($user->isLender()) {
            return app(GetAllDealsTask::class)->addRequestCriteria()->live()->ordered()->run();
        }

        return [];
    }
}
