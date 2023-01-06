<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetAllSportSponsorsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllSportSponsorsAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllSportSponsorsTask::class)->addRequestCriteria()->run();
    }
}
