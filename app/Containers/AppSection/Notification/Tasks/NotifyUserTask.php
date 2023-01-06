<?php

namespace App\Containers\AppSection\Notification\Tasks;

use App\Containers\AppSection\Notification\Enums\MailReceiver;
use App\Containers\AppSection\Notification\Enums\NotificationEntity;
use App\Containers\AppSection\Notification\Mapper\Mail;
use App\Containers\AppSection\Notification\Notifications\NotifyUserNotification;
use App\Containers\AppSection\User\Actions\GetAllAdminsAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Blade;

class NotifyUserTask extends Task
{
    /**
     * @throws InternalErrorException
     */
    public function run(User $user, $context, $data): void
    {
        $config = Mail::$MAIL[$context];
        foreach ($config['receivers'] as $receiver => $rData) {
            // check if need to validate permissions
            if (!$this->canSendNotification($user, $receiver, $data)) {
                continue;
            }
            try {
                if ($receiver === MailReceiver::ADMIN) {
                    $admins = app(GetAllAdminsAction::class)->run();
                    foreach ($admins as $admin) {
                        $entity_id = isset($data['entity_id']) ? $data['entity_id'] : $user->id;
                        if (!isset($data['allow_multiple']) || !$data['allow_multiple']) {
                            $logs = app(GetNotificationLogByTypeEntityIdAndEmailTask::class)->run($context, $entity_id, $admin->email);
                            if (!$logs->isEmpty()) {
                                return;
                            }
                        }

                        \Notification::send($admin, new NotifyUserNotification($receiver, $context, $rData, $data));
                        app(LogNotificationTask::class)->run($context, $entity_id, NotificationEntity::USER, $rData['subject'], $admin->email, $data, $receiver);
                    }
                } elseif ($receiver == MailReceiver::PARENT) {
                    // skip if no parent
                    if (is_null($user->parent_id) || !$user->parent_id) {
                        return;
                    }

                    // get parent
                    $parent = app(FindUserByIdTask::class)->run($user->parent_id);
                    // skip if parent is missing
                    if (is_null($parent)) {
                        return;
                    }

                    $entity_id = isset($data['entity_id']) ? $data['entity_id'] : $user->id;
                    if (!isset($data['allow_multiple']) || !$data['allow_multiple']) {
                        $logs = app(GetNotificationLogByTypeEntityIdAndEmailTask::class)->run($context, $entity_id, $parent->email);
                        if (!$logs->isEmpty()) {
                            return;
                        }
                    }

                    \Notification::send($user, new NotifyUserNotification($receiver, $context, $rData, $data));
                    app(LogNotificationTask::class)->run($context, $entity_id, NotificationEntity::USER, $rData['subject'], $parent->email, $data, $receiver);

                } else {
                    $entity_id = isset($data['entity_id']) ? $data['entity_id'] : $user->id;
                    if (!isset($data['allow_multiple']) || !$data['allow_multiple']) {
                        $logs = app(GetNotificationLogByTypeEntityIdAndEmailTask::class)->run($context, $entity_id, $user->email);
                        if (!$logs->isEmpty()) {
                            return;
                        }
                    }

                    \Notification::send($user, new NotifyUserNotification($receiver, $context, $rData, $data));
                    app(LogNotificationTask::class)->run($context, $entity_id, NotificationEntity::USER, $rData['subject'], $user->email, $data, $receiver);
                }
            } catch (\Exception $exception) {
                throw new InternalErrorException($exception->getMessage());
            }
        }
    }

    private function canSendNotification($user, $receiver, $data): bool
    {
        if (!isset($data['check_permission']) || !$data['check_permission'])
            return true;

        if (($user->isAdmin() && ($receiver == MailReceiver::ADMIN)) || ($user->isLender() && ($receiver == MailReceiver::LENDER)) || ($user->isBorrower() && ($receiver == MailReceiver::BORROWER))) {
            return true;
        }

        return false;
    }
}
