<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeleteAthleteAction extends Action
{
    public function run(Request $request)
    {
        $user = app(UpdateUserTask::class)->run([
            'parent_id' => null
        ], $request->user_id);

        return $user->parent_id == null;
    }
}
