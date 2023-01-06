<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetUserByIdTask;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\UserProfile\Exceptions\HasNoAccessException;
use App\Ship\Parents\Actions\Action;

class RejectUserAction extends Action
{
    /**
     * @throws \App\Ship\Exceptions\InternalErrorException
     * @throws \App\Ship\Exceptions\UpdateResourceFailedException
     * @throws \App\Ship\Exceptions\NotFoundException
     * @throws HasNoAccessException
     */
    public function run($request)
    {
        $user = app(GetUserByIdTask::class)->run($request->uid);

        if(!$user || ($user->parent_id !== $request->user()->id)) throw new HasNoAccessException();

        app(UpdateUserTask::class)->run([
            'parent_id' => null,
            'extra_data' => [
                'reject_reason' => $request->reason
            ]
        ], $request->uid);

        app(NotificationTask::class)->run($user, MailContext::PROFILE_WAS_DECLINED, ['vars' => []]);

        return $user;
    }
}
