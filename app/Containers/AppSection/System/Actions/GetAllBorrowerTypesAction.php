<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetAllBorrowerTypesTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllBorrowerTypesAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllBorrowerTypesTask::class)->addRequestCriteria()->run();
    }
}
