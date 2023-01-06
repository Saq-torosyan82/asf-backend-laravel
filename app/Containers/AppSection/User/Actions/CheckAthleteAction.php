<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\User\Exceptions\AthleteAlreadyExistsException;
use App\Containers\AppSection\User\Tasks\FindUserByFirstNameAndLastNameTask;
use App\Containers\AppSection\User\UI\API\Requests\CheckAthleteRequest;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Ship\Parents\Actions\Action;

class CheckAthleteAction extends Action
{
    public function run(CheckAthleteRequest $request)
    {
        $user = app(FindUserByFirstNameAndLastNameTask::class)->run($request->first_name, $request->last_name);
        if (!$user) {
            return [];
        }

        $userIsBorrower = $user->FindUserRoleByName(PermissionType::BORROWER);
        $borrowerType = app(GetBorrowerTypeTask::class)->run($user->id);
        if ($userIsBorrower && $borrowerType == BorrowerType::ATHLETE) {
            throw new AthleteAlreadyExistsException();
        }

        return [];
    }
}
