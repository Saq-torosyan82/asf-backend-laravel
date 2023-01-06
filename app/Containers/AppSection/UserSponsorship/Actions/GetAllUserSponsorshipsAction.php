<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\UserSponsorship\UI\API\Requests\GetAllUserSponsorshipsRequest;
use App\Ship\Parents\Actions\Action;

class GetAllUserSponsorshipsAction extends Action
{
    public function run(GetAllUserSponsorshipsRequest $request)
    {
        $user = $request->user();
        return app(GetAllUserSponsorshipsSubAction::class)->run($user->id);
    }
}
