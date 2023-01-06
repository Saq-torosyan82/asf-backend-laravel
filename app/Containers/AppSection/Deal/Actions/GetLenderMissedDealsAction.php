<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Tasks\GetAllLenderMissedDealsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetLenderMissedDealsAction extends Action
{
    public function run(Request $request, $usePagination = true)
    {
        $userId = $request->user()->id;
        return app(GetAllLenderMissedDealsTask::class)->addRequestCriteria()
                ->offerBy($userId)->missed()->ordered()->run($usePagination);
    }
}
