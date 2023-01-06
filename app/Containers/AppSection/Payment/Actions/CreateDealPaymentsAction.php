<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Deal\Exceptions\MissingAcceptedOfferException;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\GetAcceptedOfferTask;
use App\Containers\AppSection\Payment\Tasks\CreatePaymentTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Carbon\Carbon;

class CreateDealPaymentsAction extends Action
{
    public function run(Deal $deal): bool
    {
        // get lender id
        $offer = app(GetAcceptedOfferTask::class)->run($deal->id);
        // this shouldn't happen
        if (is_null($offer)) {
            throw new MissingAcceptedOfferException();
        }

        foreach ($deal->payments_data as $payment) {
            try {
                app(CreatePaymentTask::class)->run([
                    'deal_id' => $deal->id,
                    'user_id' => $deal->user_id,
                    'lender_id' => $offer->offer_by,
                    'amount' => $payment['grossAmount'],
                    'installment_nb' => $payment['index'],
                    'date' => Carbon::parse($payment['paymentDate'])->format('Y-m-d'),
                    'is_paid' => 0,
                    'paid_date' => null,
                ]);
            } catch (\Exception $e) {
                throw new CreateResourceFailedException($e->getMessage());
            }
        }

        return true;
    }
}

