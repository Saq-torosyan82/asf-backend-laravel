<?php

namespace App\Containers\AppSection\User\Traits;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;

trait IsUserParentTrait
{
    public function isUserParent(): bool
    {
        $auth = app(GetAuthenticatedUserTask::class)->run();
        $user = app(FindUserByIdTask::class)->run($this->user_id);
        return $user->parent_id === $auth->id;
    }
}
