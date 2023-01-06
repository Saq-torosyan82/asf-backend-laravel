<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Payment\Models\Payment;
use App\Containers\AppSection\Payment\Tasks\UpdatePaymentTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdatePaymentAction extends Action
{
    public function run(Request $request): Payment
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(UpdatePaymentTask::class)->run($request->id, $data);
    }
}
