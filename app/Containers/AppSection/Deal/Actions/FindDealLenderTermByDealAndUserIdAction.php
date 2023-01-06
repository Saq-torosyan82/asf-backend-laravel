<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Models\LenderTerm;
use App\Containers\AppSection\Deal\Tasks\FindDealLenderTermByDealAndUserIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindDealLenderTermByDealAndUserIdAction extends Action
{
    public function run(Request $request): LenderTerm
    {
        return app(FindDealLenderTermByDealAndUserIdTask::class)->run($request->id);
    }
}
