<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindDealByIdAction extends Action
{
    public function run(Request $request): Deal
    {
        return app(FindDealByIdTask::class)->run($request->id);
    }
}
