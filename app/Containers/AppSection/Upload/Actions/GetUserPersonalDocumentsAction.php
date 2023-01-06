<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Tasks\GetBorrowerDealDocumentsTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class GetUserPersonalDocumentsAction extends Action
{
    public function run(User $user, string $contract_type)
    {
        return app(GetBorrowerDealDocumentsTask::class)->run($user->id, $contract_type);
    }
}
