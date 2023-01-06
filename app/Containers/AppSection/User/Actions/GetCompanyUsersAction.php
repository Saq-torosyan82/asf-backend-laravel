<?php

namespace App\Containers\AppSection\User\Actions;


use App\Containers\AppSection\User\Tasks\GetChildUsersByParentIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetCompanyUsersAction extends Action
{
    public function run(Request $request)
    {
        return app(GetChildUsersByParentIdTask::class)->run([$request->user()->id]);
    }
}
