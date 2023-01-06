<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\UserSponsorship\Tasks\DeleteUserSponsorshipTask;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\DeleteUserSponsorshipAgentRequest;
use App\Ship\Parents\Actions\Action;
use Exception;

class DeleteUserSponsorshipAgentAction extends Action
{
    public function run(DeleteUserSponsorshipAgentRequest $request)
    {
        try {
            return app(DeleteUserSponsorshipTask::class)->run($request->userId, $request->sponsorshipId);
        } catch(Exception $exception) {
            throw new Exception();
        }
    }
}
