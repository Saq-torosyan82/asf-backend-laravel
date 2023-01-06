<?php

namespace App\Containers\AppSection\Notification\Tasks;

use App\Containers\AppSection\Notification\Data\Repositories\NotificationsLogsRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class CreateNotificationLogTask extends Task
{
    protected NotificationsLogsRepository $repository;

    public function __construct(NotificationsLogsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run($data): void
    {
        try {
            $this->repository->create($data);
        } catch ( \Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }
    }
}
