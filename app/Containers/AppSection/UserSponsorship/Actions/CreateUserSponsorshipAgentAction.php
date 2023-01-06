<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\UserSponsorship\Exceptions\CreateUserSponsorshipException;
use App\Containers\AppSection\UserSponsorship\Models\UserSponsorship;
use App\Containers\AppSection\UserSponsorship\Tasks\CreateUserSponsorshipTask;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\CreateUserSponsorshipAgentRequest;
use App\Ship\Parents\Actions\Action;
use Exception;

class CreateUserSponsorshipAgentAction extends Action
{
    public function run(CreateUserSponsorshipAgentRequest $request): UserSponsorship
    {
        try {
            return app(CreateUserSponsorshipTask::class)->run($request->userId, $request->type, $request->id);
        } catch(Exception $exception) {
            throw new CreateUserSponsorshipException();
        }
    }
}
