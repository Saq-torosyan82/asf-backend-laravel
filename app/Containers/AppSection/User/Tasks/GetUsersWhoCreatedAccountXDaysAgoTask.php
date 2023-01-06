<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\Notification\Data\Repositories\NotificationsLogsRepository;
use App\Containers\AppSection\Notification\Models\NotificationsLogs;
use App\Containers\AppSection\User\Data\Criterias\NoUserProfileData;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class GetUsersWhoCreatedAccountXDaysAgoTask extends Task
{
    protected UserRepository $repository;
    protected NotificationsLogsRepository $notificationsLogsRepository;

    public function __construct(UserRepository $repository,  NotificationsLogsRepository $notificationsLogsRepository)
    {
        $this->repository = $repository;
        $this->notificationsLogsRepository = $notificationsLogsRepository;
    }

    public function run(int $days)
    {
        return $this->repository->doesntHave('UserProfile')
                    ->whereDate('created_at', '=', Carbon::now()->subDays($days))->whereNotNull('email_verified_at')->get();
    }
}
