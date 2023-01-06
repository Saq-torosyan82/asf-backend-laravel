<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileFieldTask;
use App\Containers\AppSection\UserProfile\Tasks\UpdateUserProfileTask;
use App\Containers\AppSection\UserProfile\Tasks\CreateUserProfileTask;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\BadRequestException;
use App\Ship\Exceptions\ConflictException;

class AddPreviousTeamsAction extends Action
{
    public function run(Request $request)
    {
        $userId = $request->user()->id;
        if($request->user()->isAgent()) {
            if(!isset($request->user_id)) {
                throw new BadRequestException('The user_id is requried!');
            }

            $userId = $request->user_id;
        } else if(!$request->user()->isAthlete())
            throw new ConflictException('The user must be borrower!');

        $teams = [];
        foreach($request->teams as $team) {
            if(is_int($team) && $team) {
                $teams[] = $team;
            }
        }

        $previousClubs = app(FindUserProfileFieldTask::class)->run($userId, Group::PROFESSIONAL, Key::PREVIOUS_CLUBS);
        if($previousClubs == null) {
            app(CreateUserProfileTask::class)->run($userId, Key::PREVIOUS_CLUBS, Group::PROFESSIONAL, json_encode($teams));
        } else {
            $previousTeams = json_decode($previousClubs->value);
            $teams = array_unique(array_merge($previousTeams, $teams));
            app(UpdateUserProfileTask::class)->run($previousClubs->id, json_encode(array_values($teams)));
        }
    }
}
