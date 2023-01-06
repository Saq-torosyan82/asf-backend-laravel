<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\GetUsersProfileByKeyAndValueTask;
use App\Ship\Parents\Actions\Action;

class GetAllClubsAction extends Action
{
    public function run()
    {
        return app(GetUsersProfileByKeyAndValueTask::class)->run(Group::ACCOUNT, Key::BORROWER_TYPE, BorrowerType::CORPORATE);
    }
}
