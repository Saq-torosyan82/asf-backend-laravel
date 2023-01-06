<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\DisableUserAccountTask;
use App\Containers\AppSection\User\UI\API\Requests\DisableUserAccountRequest;
use App\Ship\Parents\Actions\Action;

class DisableUserAccountAction extends Action
{
    public function run(DisableUserAccountRequest $request): void
    {
        app(DisableUserAccountTask::class)->run($request->id);
    }
}
