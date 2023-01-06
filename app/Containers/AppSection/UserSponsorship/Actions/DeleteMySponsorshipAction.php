<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\UserSponsorship\UI\API\Requests\DeleteMySponsorshipRequest;
use App\Ship\Parents\Actions\Action;
use Exception;

class DeleteMySponsorshipAction extends Action
{
    public function run(DeleteMySponsorshipRequest $request)
    {
        try {
            $user = $request->user();
            return app(DeleteUserSponsorshipSubAction::class)->run($user->id, $request->id);
        } catch (Exception $exception) {
            throw new Exception();
        }
    }
}
