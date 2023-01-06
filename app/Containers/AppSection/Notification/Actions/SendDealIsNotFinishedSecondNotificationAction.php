<?php

namespace App\Containers\AppSection\Notification\Actions;

use App\Containers\AppSection\Deal\Tasks\GetAllDealsTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\User\Tasks\GetAutologinUrlTask;
use App\Ship\Parents\Actions\Action;

class SendDealIsNotFinishedSecondNotificationAction extends Action
{
    public function run()
    {
        $deals = app(GetAllDealsTask::class)
            ->createdAt(config('notifications.deal.notFinished.second_reminder'))
            ->notStarted()
            ->liveDeal()
            ->run();

        foreach ($deals as $deal) {
            $data = [
                'vars' => [
                    'linkToDeal' => config('appSection-authentication.login_token_redirect') . '/deals?id='.$deal->getHashedKey(),
                    'email' => $deal->user->email,
                    'firstName' => $deal->user->first_name,
                    'lastName' => $deal->user->last_name,
                    'autologin_url' => app(GetAutologinUrlTask::class)->run($deal->user)
                ]
            ];
            try {
                app(NotificationTask::class)->run($deal, MailContext::DEAL_IS_NOT_COMPLETED_SECOND_REMINDER, $data);
            } catch (\Exception $e) {
                \Log::error(sprintf('[deal_id: %s] error sending second deal notification: %s', $deal->id, $e->getMessage()));
            }
        }
    }
}
