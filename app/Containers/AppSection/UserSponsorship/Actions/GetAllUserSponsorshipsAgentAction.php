<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\UserSponsorship\UI\API\Requests\GetAllUserSponsorshipsAgentRequest;
use App\Ship\Parents\Actions\Action;

class GetAllUserSponsorshipsAgentAction extends Action
{
    public function run(GetAllUserSponsorshipsAgentRequest $request)
    {
        return app(GetAllUserSponsorshipsSubAction::class)->run($request->userId);
    }
}
