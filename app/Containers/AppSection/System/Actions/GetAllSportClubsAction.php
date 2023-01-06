<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetAllSportClubsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllSportClubsAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllSportClubsTask::class)->addRequestCriteria(null, ['id', 'league_id', 'country_id', 'sport_id', 'league.sport_id'])->run();
    }
}
