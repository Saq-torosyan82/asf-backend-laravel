<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetAllClubCountriesTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllClubCountriesAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllClubCountriesTask::class)->addRequestCriteria(null, ['id', 'clubs.league.sport_id'])->run();
    }
}
