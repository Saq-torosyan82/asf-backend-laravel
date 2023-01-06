<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetAllSportBrandsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllSportBrandsAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllSportBrandsTask::class)->addRequestCriteria()->run();
    }
}
