<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\System\Tasks\GetSportClubByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Ship\Parents\Tasks\Task;

class GetBorrowerNameTask extends Task
{
    /**
     * @throws \App\Ship\Exceptions\NotFoundException
     */
    public function run(User $user): string
    {
        if ($user->isCorporate()) {
            $userProfile = app(GetUsersProfileByKeyAndValueTask::class)->run(Group::PROFESSIONAL, Key::CLUB);
            return app(GetSportClubByIdTask::class)->run($userProfile->value)->name;
        }elseif ($user->isAgent()) {
            return app(GetUsersProfileByKeyAndValueTask::class)->run(Group::COMPANY, Key::NAME)->value;
        }

        return $user->first_name. ' '. $user->last_name;
    }
}
