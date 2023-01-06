<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Payment\Tasks\DeletePaymentTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeletePaymentAction extends Action
{
    public function run(Request $request)
    {
        return app(DeletePaymentTask::class)->run($request->id);
    }
}
