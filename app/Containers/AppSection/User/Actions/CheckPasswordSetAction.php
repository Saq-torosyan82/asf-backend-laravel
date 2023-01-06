<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\CheckPasswordSetTask;
use App\Ship\Parents\Actions\Action;

class CheckPasswordSetAction extends Action
{
    public function run(int $userId): bool
    {
        return app(CheckPasswordSetTask::class)->run($userId);
    }
}
