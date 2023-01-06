<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetAllSportLeaguesTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllSportLeaguesAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllSportLeaguesTask::class)->addRequestCriteria(null, ['id', 'sport_id', 'SportClubs.country_id'])->run();
    }
}
