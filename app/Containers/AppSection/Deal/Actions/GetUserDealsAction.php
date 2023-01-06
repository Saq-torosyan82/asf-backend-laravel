<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Tasks\GetDealsByUserIdTask;
use App\Ship\Exceptions\ConflictException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetUserDealsAction extends Action
{
    public function run(Request $request, $userId)
    {
        if(empty($userId)) throw new ConflictException('The user is invalid!');

        return app(GetDealsByUserIdTask::class)->run($userId);
    }
}
