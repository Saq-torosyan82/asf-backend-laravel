<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Payment\Tasks\UpdatePaymentTask;
use App\Containers\AppSection\Payment\Tasks\FindPaymentByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\NotAuthorizedResourceException;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Actions\Action;

class PayPaymentAction extends Action
{
    public function run(Request $request)
    {
        $payment = app(FindPaymentByIdTask::class)->run($request->id);
        if($payment == null) throw new NotFoundException();

        if(!$request->user()->hasAdminRole() && $request->user()->id != $payment->user_id) 
            throw new NotAuthorizedResourceException();

        return app(UpdatePaymentTask::class)->run($request->id, [
            'is_paid' => true,
            'paid_date' => now()
        ]);
    }
}
