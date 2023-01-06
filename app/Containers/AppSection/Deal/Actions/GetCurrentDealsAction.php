<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Tasks\GetAllLenderOffersTask;
use App\Containers\AppSection\Deal\Tasks\GetCurrentDealsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetCurrentDealsAction extends Action
{
    public function run(Request $request, $usePagination = true)
    {
        $userId = $request->user()->id;
        return app(GetAllLenderOffersTask::class)->addRequestCriteria()->offerBy($userId)->current()->ordered()->run($usePagination);
    }
}
