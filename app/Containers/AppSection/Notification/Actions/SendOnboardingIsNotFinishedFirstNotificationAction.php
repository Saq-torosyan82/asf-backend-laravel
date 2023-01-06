<?php

namespace App\Containers\AppSection\Notification\Actions;

use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\User\Tasks\GetAutologinUrlTask;
use App\Containers\AppSection\User\Tasks\GetUsersWhoCreatedAccountXDaysAgoTask;
use App\Ship\Parents\Actions\Action;

class SendOnboardingIsNotFinishedFirstNotificationAction extends Action
{
    public function run(): void
    {
        $users = app(GetUsersWhoCreatedAccountXDaysAgoTask::class)
            ->run(config('notifications.borrower.period.first_reminder'));

        foreach ($users as $user) {
            $data = [
                'vars' => [
                    'email' => $user->email,
                    'autologin_url' => app(GetAutologinUrlTask::class)->run($user)
                ]
            ];
            try {
                app(NotificationTask::class)->run($user, MailContext::ONBOARDING_IS_NOT_FINISHED_FIRST_REMINDER, $data);
            } catch (\Exception $e) {
                \Log::error(sprintf('[user_id: %s] error sending first onboarding notification: %s', $user->id, $e->getMessage()));
            }
        }
    }
}
