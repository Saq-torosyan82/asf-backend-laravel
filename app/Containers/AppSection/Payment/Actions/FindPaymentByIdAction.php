<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Payment\Models\Payment;
use App\Containers\AppSection\Payment\Tasks\FindPaymentByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindPaymentByIdAction extends Action
{
    public function run(Request $request): Payment
    {
        return app(FindPaymentByIdTask::class)->run($request->id);
    }
}
