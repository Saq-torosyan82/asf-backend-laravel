<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\Payment\Tasks\GetDealsPaymentsToSendReminderTask;
use App\Containers\AppSection\Payment\Tasks\UpdatePaymentTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Log;

class SendSecondPaymentReminderAction extends Action
{
    public function run(): void
    {
        $daysBefore = config('appSection-payment.reminders.days_before.second_reminder');
        $payments = app(GetDealsPaymentsToSendReminderTask::class)->run($daysBefore);
        foreach ($payments as $payment) {
            $extraData = $payment->extra_data;

            // skip if notification was sent
            if (isset($extraData['second_reminder_sent']) && $extraData['second_reminder_sent']) {
                continue;
            }

            // SEEMEk: should we check if first notification was sent ??

            try {
                // send notification
                $data = [
                    // maybe add more data
                    'vars' => [
                        'amount' => $payment->amount,
                        'date' => $payment->date,
                        'name' => $payment->user->first_name . ' ' . $payment->user->last_name,
                        'deal_date' => $payment->deal->created_at,
                    ],
                    'entity_id' => $payment->id
                ];
                app(NotificationTask::class)->run($payment->user, MailContext::PAYMENT_SECOND_REMINDER, $data);
                Log::info(sprintf('[id:%d] sent second notification', $payment->id));
                $extraData['second_reminder_sent'] = 1;
                $paymentData['extra_data'] = $extraData;
                app(UpdatePaymentTask::class)->run($payment->id, $paymentData);
            } catch (\Exception $exception) {
                Log::error(sprintf('[id:%d] error sending second notification %s', $payment->id, $exception->getMessage()));
            }
        }
    }
}
