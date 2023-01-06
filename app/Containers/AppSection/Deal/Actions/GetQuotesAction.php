<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Tasks\GetAllDealsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetQuotesAction extends Action
{
    public function run(Request $request, $usePagination = true)
    {
        $userId = $request->user()->id;
        return app(GetAllDealsTask::class)->addRequestCriteria()->user($userId)->future()->period()->ordered()->run($usePagination);
    }
}
