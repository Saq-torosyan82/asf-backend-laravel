<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Payment\Tasks\GetAllPaymentsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllPaymentsAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllPaymentsTask::class)->addRequestCriteria()->run();
    }
}
