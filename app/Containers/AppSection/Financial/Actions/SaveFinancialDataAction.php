<?php

namespace App\Containers\AppSection\Financial\Actions;

use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileFieldTask;
use App\Containers\AppSection\Financial\Tasks\FindFinancialsTask;
use App\Containers\AppSection\Financial\Tasks\CreateFinancialDataTask;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Ship\Exceptions\ConflictException;
use App\Ship\Exceptions\NotAuthorizedResourceException;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Actions\Action;

class SaveFinancialDataAction extends Action
{
    public function run(Request $request)
    {
        $club = app(FindUserProfileFieldTask::class)->run($request->user()->id, Group::PROFESSIONAL, Key::CLUB);

        if ($club == null) {
            throw new ConflictException("No professional club assigned");
        }

        $financials = app(FindFinancialsTask::class)->run(['club_id' => $club->value]);

        if (count($financials) == 0 || $financials[0]->season_id == null) {
            throw new ConflictException("Financial not found!");
        }

        if ($financials[0]->is_blocked == 1) {
            throw new NotAuthorizedResourceException("The financial is blocked!");
        }

        app(CreateFinancialDataTask::class)->run($financials[0]->id, $request->id, $request->value,);
    }

}
