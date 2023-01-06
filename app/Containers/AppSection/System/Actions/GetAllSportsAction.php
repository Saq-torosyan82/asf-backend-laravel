<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetAllSportsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllSportsAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllSportsTask::class)->addRequestCriteria()->run();
    }
}
