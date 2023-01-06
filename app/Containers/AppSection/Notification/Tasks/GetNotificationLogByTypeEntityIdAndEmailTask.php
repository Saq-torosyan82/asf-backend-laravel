<?php

namespace App\Containers\AppSection\Notification\Tasks;

use App\Containers\AppSection\Notification\Data\Repositories\NotificationsLogsRepository;
use App\Ship\Parents\Tasks\Task;

class GetNotificationLogByTypeEntityIdAndEmailTask extends Task
{
    protected NotificationsLogsRepository $repository;

    public function __construct(NotificationsLogsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($type, $entityId, $email)
    {
        return $this->repository->where('type', $type)->where('entity_id', $entityId)->where('to', $email)->get();
    }
}
