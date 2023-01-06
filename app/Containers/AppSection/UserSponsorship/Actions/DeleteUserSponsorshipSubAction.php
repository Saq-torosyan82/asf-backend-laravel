<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\UserSponsorship\Tasks\DeleteUserSponsorshipTask;
use App\Ship\Parents\Actions\SubAction;

class DeleteUserSponsorshipSubAction extends SubAction
{
    public function run(int $userId, int $sponsorshipId)
    {
        return app(DeleteUserSponsorshipTask::class)->run($userId, $sponsorshipId);
    }
}
