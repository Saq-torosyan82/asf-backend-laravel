<?php

namespace App\Containers\AppSection\Financial\Actions;

use App\Containers\AppSection\Financial\Tasks\GetAllFinancialsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllFinancialsAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllFinancialsTask::class)->addRequestCriteria()->run();
    }
}
