<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\UserSponsorship\Tasks\DeleteUserSponsorshipTask;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\DeleteUserSponsorshipRequest;
use App\Ship\Parents\Actions\Action;
use Exception;

class DeleteUserSponsorshipAction extends Action
{
    public function run(DeleteUserSponsorshipRequest $request)
    {
        try {
            return app(DeleteUserSponsorshipTask::class)->run($request->userId, $request->sponsorshipId);
        } catch(Exception $exception) {
            throw new Exception();
        }
    }
}
