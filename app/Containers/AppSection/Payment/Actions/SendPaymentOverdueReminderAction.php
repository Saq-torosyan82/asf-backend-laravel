<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\Payment\Mails\PaymentOverdueReminderEmail;
use App\Containers\AppSection\Payment\Tasks\GetOverduesPaymentsTask;
use App\Containers\AppSection\Payment\Tasks\UpdatePaymentTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPaymentOverdueReminderAction extends Action
{
    public function run(): void
    {
        $payments = app(GetOverduesPaymentsTask::class)->run();

        foreach ($payments as $payment) {
            $extraData = $payment->extra_data;
            if (!isset($extraData['is_overdue']) || !$extraData['is_overdue'] ||
                (isset($extraData['overdue_reminder_sent']) && $extraData['overdue_reminder_sent'])) {
                continue;
            }

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
                app(NotificationTask::class)->run($payment->user, MailContext::PAYMENT_OVERDUE_REMINDER, $data);
                Log::info(sprintf('[id:%d] sent overdue notification', $payment->id));

                $extraData['overdue_reminder_sent'] = 1;
                $paymentData['extra_data'] = $extraData;
                app(UpdatePaymentTask::class)->run($payment->id, $paymentData);
            } catch (\Exception $exception) {
                Log::error(sprintf('[id:%d] error sending overdue notification %s', $payment->id, $exception->getMessage()));
            }
        }
    }
}
