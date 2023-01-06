<?php

namespace App\Containers\AppSection\Notification\Tasks;

use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Notification\Exceptions\InvalidContextException;
use App\Containers\AppSection\Notification\Exceptions\InvalidEntityException;
use App\Containers\AppSection\Notification\Mapper\Mail;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Tasks\Task;

class NotificationTask extends Task
{
    /**
     * @throws InternalErrorException
     */
    public function run($entity, $context, $data): void
    {
        if(!isset(Mail::$MAIL[$context])){
            throw new InvalidContextException();
        }

        // validate instance type
        if(get_class($entity) != Mail::$MAIL[$context]['entity']){
            throw new InvalidEntityException();
        }

        try {
            switch ($entity) {
                case $entity instanceof Deal:
                    app(NotifyDealUsersTask::class)->run($entity, $context, $data);
                    break;
                case $entity instanceof User:
                    app(NotifyUserTask::class)->run($entity, $context, $data);
                    break;
            }
        }catch (\Exception $exception) {
            throw new InternalErrorException($exception->getMessage());
        }
    }
}
