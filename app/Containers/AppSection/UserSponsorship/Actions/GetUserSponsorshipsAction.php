<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\UserSponsorship\UI\API\Requests\GetUserSponsorshipsRequest;
use App\Ship\Parents\Actions\Action;

class GetUserSponsorshipsAction extends Action
{
    public function run(GetUserSponsorshipsRequest $request)
    {
        return app(GetAllUserSponsorshipsSubAction::class)->run($request->userId);
    }
}
