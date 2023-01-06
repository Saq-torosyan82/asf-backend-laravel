<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Deal\Tasks\GetCounterpartyNameTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\Payment\Tasks\GetDealsPaymentsToSendReminderTask;
use App\Containers\AppSection\Payment\Tasks\UpdatePaymentTask;
use App\Containers\AppSection\User\Actions\SetLoginTokenSubAction;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Exceptions\MissingUserException;
use App\Ship\Parents\Actions\Action;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendPaymentConfirmationAction extends Action
{
    public function run(): void
    {
        $daysBefore = config('appSection-payment.reminders.days_before.payment_confirmation');
        $payments = app(GetDealsPaymentsToSendReminderTask::class)->run($daysBefore);
        foreach ($payments as $payment) {
            $extraData = $payment->extra_data;

            // skip if notification was sent
            if (isset($extraData['lender_confirmation_sent']) && $extraData['lender_confirmation_sent']) {
                continue;
            }

            try {
                $lender = app(FindUserByIdTask::class)->run($payment->lender_id);
                if (is_null($lender)) {
                    throw new MissingUserException('missing lender with id ' . $payment->lender_id);
                }
                $loginToken = app(SetLoginTokenSubAction::class)->run($lender->id, 262800); //262800 6 months

                $confirmPaymentRoute = config('appSection-payment.confirm_payment_route');

                $fullUrl = "{$confirmPaymentRoute}?token={$loginToken}&uid={$lender->getHashedKey()}&payment={$payment->getHashedKey()}";

                // send notification
                $data = [
                    // maybe add more data
                    'vars' => [
                        'borrower_name' => $payment->user->first_name . ' ' . $payment->user->last_name,
                        'lender_name' => $lender->first_name . ' ' . $lender->last_name,
                        'date' => Carbon::parse($payment->date)->format('d/m/Y'),
                        'amount' => $payment->amount,
                        'currency' => $payment->deal->currency,
                        'obligor_risk_name' => app(GetCounterpartyNameTask::class)->run($payment->deal),
                        'login_url' => $fullUrl,
                    ],
                    'entity_id' => $payment->id,
                    'lenders_ids' => [$payment->lender_id]
                ];
                app(NotificationTask::class)->run($lender, MailContext::PAYMENT_CONFIRMATION, $data);
                Log::info(sprintf('[id:%d] sent payment confirmation', $payment->id));
                $extraData['lender_confirmation_sent'] = 1;
                $paymentData['extra_data'] = $extraData;
                app(UpdatePaymentTask::class)->run($payment->id, $paymentData);
            } catch (\Exception $exception) {
                Log::error(sprintf('[id:%d] error sending payment confirmation %s', $payment->id, $exception->getMessage()));
            }
        }
    }
}
