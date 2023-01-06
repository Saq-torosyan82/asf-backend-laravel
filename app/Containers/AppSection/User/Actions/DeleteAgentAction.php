<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\GetAgentByIdTask;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\UI\API\Requests\DeleteAgentRequest;
use App\Ship\Parents\Actions\Action;

class DeleteAgentAction extends Action
{
    public function run(DeleteAgentRequest $request): \App\Containers\AppSection\User\Models\User
    {
        $agent = app(UpdateUserTask::class)->run([
            'is_active' => 0
        ], $request->id);

        return $agent;
    }
}
