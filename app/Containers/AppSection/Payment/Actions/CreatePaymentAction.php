<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Payment\Models\Payment;
use App\Containers\AppSection\Payment\Tasks\CreatePaymentTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class CreatePaymentAction extends Action
{
    public function run(Request $request): Payment
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(CreatePaymentTask::class)->run($data);
    }
}
