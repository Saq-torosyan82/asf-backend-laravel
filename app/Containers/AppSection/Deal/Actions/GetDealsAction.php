<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\Deal\Tasks\GetAllLenderDealsTask;
use App\Containers\AppSection\Deal\Tasks\GetDealsByUserIdTask;
use App\Containers\AppSection\Deal\Tasks\GetAllDealsTask;
use App\Containers\AppSection\Deal\Tasks\GetDealsByUsersIdsTask;
use App\Containers\AppSection\User\Tasks\GetChildUsersByParentIdTask;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use App\Ship\Exceptions\ConflictException;

class GetDealsAction extends Action
{
    public function run(Request $request, $usePagination = true)
    {
        $roles = $request->user()->roles;
        $userId = $request->user()->id;

        if($roles->where('name', PermissionType::ADMIN)->first()) {
            return app(GetAllDealsTask::class)->addRequestCriteria()->run();
        }

        if($roles->where('name', PermissionType::LENDER)->first()) {
            return app(GetAllLenderDealsTask::class)->run($userId);
        }

        $borrowerType = app(GetBorrowerTypeTask::class)->run($userId);
        if($borrowerType == null) throw new ConflictException('The user must be borrower!');

        if($borrowerType == BorrowerType::AGENT) {
            $childUsers = app(GetChildUsersByParentIdTask::class)->run([$userId]);
            $usersIds = $childUsers->pluck('id')->ToArray();
            $usersIds[] = $userId;

            return app(GetAllDealsTask::class)->addRequestCriteria()->users($usersIds)->ordered()->run($usePagination);
        }

        return app(GetAllDealsTask::class)->addRequestCriteria()->user($userId)->ordered()->run($usePagination);
    }
}
