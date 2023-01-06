<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Exceptions\EmailAlreadyUsedException;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Containers\AppSection\User\UI\API\Requests\CheckEmailAvailabilityRequest;
use App\Ship\Parents\Actions\Action;

class CheckEmailAvailabilityAction extends Action
{
    public function run(CheckEmailAvailabilityRequest $request)
    {
        $user = app(FindUserByEmailTask::class)->run($request->email);

        if(is_null($user))
        {
            return [];
        }

        throw new EmailAlreadyUsedException();
    }
}
