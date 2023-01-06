<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Tasks\GetAllDealsTask;
use App\Containers\AppSection\Deal\Tasks\GetDealsByCounterpartyTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetDealsByCounterpartyAction extends Action
{
    public function run(Request $request)
    {
        return app(GetDealsByCounterpartyTask::class)->run($request->counterparty);
    }
}
