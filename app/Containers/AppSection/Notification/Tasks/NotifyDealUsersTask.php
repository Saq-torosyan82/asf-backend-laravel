<?php

namespace App\Containers\AppSection\Notification\Tasks;

use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Notification\Enums\MailReceiver;
use App\Containers\AppSection\Notification\Enums\NotificationEntity;
use App\Containers\AppSection\Notification\Mapper\Mail;
use App\Containers\AppSection\Notification\Notifications\NotifyUserNotification;
use App\Containers\AppSection\User\Data\Criterias\AdminsCriteria;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Tasks\GetUsersByIdsTask;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Parents\Tasks\Task;

class NotifyDealUsersTask extends Task
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws InternalErrorException
     */
    public function run(Deal $deal, $context, $data): void
    {
        try {
            $config = Mail::$MAIL[$context];
            foreach ($config['receivers'] as $receiver => $rData) {
                if ($receiver === MailReceiver::LENDER) {
                    if (isset($data['lenders_ids']) && count($data['lenders_ids'])) {
                        $lenders = app(GetUsersByIdsTask::class)->run($data['lenders_ids']);
                        foreach ($lenders as $lender) {
                            $entity_id = isset($data['entity_id']) ? $data['entity_id'] : $deal->id;
                            $logs = app(GetNotificationLogByTypeEntityIdAndEmailTask::class)->run($context, $entity_id, $lender->email);
                            $fullName = trim($lender->first_name . ' ' . $lender->last_name);
                            $data['vars']['lender_full_name'] = $fullName ? : $lender->email;
                            if ($logs->isEmpty()) {
                                \Notification::send($lender, new NotifyUserNotification($receiver, $context, $rData, $data));
                                app(LogNotificationTask::class)->run($context, $entity_id, NotificationEntity::DEAL, $rData['subject'], $lender->email, $data, $receiver);
                            }
                        }
                    } else {
                        throw new ValidationFailedException("No lenders ids found");
                    }
                } elseif ($receiver === MailReceiver::BORROWER) {
                    $entity_id = isset($data['entity_id']) ? $data['entity_id'] : $deal->id;
                    $logs = app(GetNotificationLogByTypeEntityIdAndEmailTask::class)->run($context, $entity_id, $deal->user->email);
                    if ($logs->isEmpty()) {
                        \Notification::send($deal->user,
                            new NotifyUserNotification($receiver, $context, $rData, $data));
                        app(LogNotificationTask::class)->run($context, $entity_id, NotificationEntity::DEAL, $rData['subject'], $deal->user->email, $data, $receiver);
                    }
                } elseif ($receiver === MailReceiver::ADMIN) {
                    $admins = $this->userRepository->pushCriteria(new AdminsCriteria())->get();
                    foreach ($admins as $admin) {
                        $entity_id = isset($data['entity_id']) ? $data['entity_id'] : $deal->id;
                        $logs = app(GetNotificationLogByTypeEntityIdAndEmailTask::class)->run($context, $entity_id, $admin->email);
                        if ($logs->isEmpty()) {
                            \Notification::send($admin,
                                new NotifyUserNotification($receiver, $context, $rData, $data));
                            app(LogNotificationTask::class)->run($context, $entity_id, NotificationEntity::DEAL, $rData['subject'], $admin->email, $data, $receiver);
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            throw new InternalErrorException($exception->getMessage());
        }
    }
}
