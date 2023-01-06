<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Tasks\GetUsersProfileByKeyAndValueTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Actions\Action;

class CheckOrganisationAction extends Action
{
    public function run(Request $request)
    {
        $userProfiles = app(GetUsersProfileByKeyAndValueTask::class)->run(Group::PROFESSIONAL, Key::CLUB, $request->id);
        
        if(count($userProfiles) > 0) {
            foreach($userProfiles as $userProfile) {
                $borrowerType = app(GetBorrowerTypeTask::class)->run($userProfile->user_id);
                if($borrowerType == BorrowerType::CORPORATE) {
                    return true;
                }
            }
        }

        return false;
    }
}
