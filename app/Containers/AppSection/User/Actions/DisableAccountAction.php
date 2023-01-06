<?php

namespace App\Containers\AppSection\User\Actions;

use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\User\Tasks\DisableUserAccountTask;
use App\Containers\AppSection\User\UI\API\Requests\DisableAccountRequest;

class DisableAccountAction extends Action
{
    public function run(DisableAccountRequest $request)
    {
        $userId = $request->user()->id;
        app(DisableUserAccountTask::class)->run($userId);
    }
}
