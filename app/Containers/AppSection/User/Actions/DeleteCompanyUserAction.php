<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\UI\API\Requests\DeleteCompanyUserRequest;
use App\Ship\Parents\Actions\Action;

class DeleteCompanyUserAction extends Action
{
    public function run(DeleteCompanyUserRequest $request): void
    {
        app(UpdateUserTask::class)->run([
            'parent_id' => NULL
        ], $request->id);
    }
}
