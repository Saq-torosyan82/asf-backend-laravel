<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\System\Tasks\FindBorrowerTypeByIdTask;
use App\Containers\AppSection\User\Exceptions\InvalidUserException;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;

class GetAuthenticatedUserTypeTask extends Task
{
    public function run(User $user)
    {
        // check for borrower
        if ($user->FindUserRoleByName(PermissionType::BORROWER)) {
            try {
                // get user type form profile
                return app(GetBorrowerTypeTask::class)->run($user->id);
            } catch (NotFoundException $d) {
                return null;
            } catch (\Exception $e) {
                throw $e;
            }
        }

        // check if user is lender
        if ($user->FindUserRoleByName(PermissionType::LENDER)) {
            return PermissionType::LENDER;
        }

        if ($user->FindUserRoleByName(PermissionType::ADMIN)) {
            return PermissionType::ADMIN;
        }

        throw new InvalidUserException();
    }
}
