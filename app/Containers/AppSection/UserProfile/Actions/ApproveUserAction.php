<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\User\Actions\SetLoginTokenSubAction;
use App\Containers\AppSection\User\Tasks\GetAutologinUrlTask;
use App\Containers\AppSection\User\Tasks\GetUserByIdTask;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\UserProfile\Exceptions\HasNoAccessException;
use App\Ship\Parents\Actions\Action;


class ApproveUserAction extends Action
{
    public function run($request)
    {
        $user = app(GetUserByIdTask::class)->run($request->uid);

        if(!$user || $user->parent_id !== $request->user()->id) throw new HasNoAccessException();

        app(UpdateUserTask::class)->run([
            'is_locked' => 0,
        ], $request->uid);

        $loginToken = app(SetLoginTokenSubAction::class)->run($user->id, 10);
        $loginTokenRedirect = config('appSection-authentication.login_token_redirect');

        $data = [
            'vars' => [
                'autologin_url' => "{$loginTokenRedirect}?token={$loginToken}&uid={$user->getHashedKey()}"
            ]
        ];

        app(NotificationTask::class)->run($user, MailContext::PROFILE_WAS_APPROVED, $data);

        return $user;
    }
}
