<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetAllTvRightsHoldersTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllTvRightsHoldersAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllTvRightsHoldersTask::class)->addRequestCriteria()->run();
    }
}
