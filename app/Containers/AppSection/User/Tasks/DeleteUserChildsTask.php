<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class DeleteUserChildsTask extends Task
{

    public function run(User $user): void
    {
        $user->childs()->delete();
    }
}
