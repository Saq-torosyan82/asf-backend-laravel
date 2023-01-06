<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\UserSponsorship\Exceptions\CreateUserSponsorshipException;
use App\Containers\AppSection\UserSponsorship\Exceptions\UserSponsorshipExistsException;
use App\Containers\AppSection\UserSponsorship\Models\UserSponsorship;
use App\Containers\AppSection\UserSponsorship\Tasks\CreateUserSponsorshipTask;
use App\Containers\AppSection\UserSponsorship\Tasks\FindlUserSponsorshipsByTypeTask;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\CreateUserSponsorshipRequest;
use App\Ship\Parents\Actions\Action;
use Exception;

class CreateUserSponsorshipAction extends Action
{
    public function run(CreateUserSponsorshipRequest $request): UserSponsorship
    {
        try {

            // check if sponsorship already exists
            $sponsor = app(FindlUserSponsorshipsByTypeTask::class)->run($request->userId, $request->type, $request->id);
            if (!is_null($sponsor)) {
                throw new UserSponsorshipExistsException();
            }

            return app(CreateUserSponsorshipTask::class)->run($request->userId, $request->type, $request->id);
        } catch (UserSponsorshipExistsException $e) {
            throw $e;
        } catch (Exception $exception) {
            throw new CreateUserSponsorshipException();
        }
    }
}
