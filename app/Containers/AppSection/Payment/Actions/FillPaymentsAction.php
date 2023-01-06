<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Payment\Tasks\GetDealsContractSignedPaymentTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action;

class FillPaymentsAction extends Action
{
    /**
     * @throws CreateResourceFailedException
     */
    public function run(): void
    {
        $deals = app(GetDealsContractSignedPaymentTask::class)->run();

        foreach ($deals as $deal) {
            app(CreateDealPaymentsAction::class)->run($deal);
        }
    }
}
