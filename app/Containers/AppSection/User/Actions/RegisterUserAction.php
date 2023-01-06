<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Events\UserRegisteredEvent;
use App\Containers\AppSection\User\Mails\UserRegisteredMail;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Notifications\UserRegisteredNotification;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\User\UI\API\Requests\RegisterUserRequest;
use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class RegisterUserAction extends Action
{
    public function run(RegisterUserRequest $request): User
    {
        $user = app(CreateUserByCredentialsTask::class)->run(
            false,
            $request->email,
            $request->password,
            $request->first_name,
            $request->last_name,
            $request->gender,
            $request->birth
        );

        $user->assignRole(app(FindRoleTask::class)->run(PermissionType::BORROWER));

        $loginTokenExpiration = config('appSection-authentication.login_token_expiration');
        app(SetLoginTokenSubAction::class)->run($user->id, $loginTokenExpiration);

        Mail::send(new UserRegisteredMail($user));
        app(Dispatcher::class)->dispatch(new UserRegisteredEvent($user));

        return $user;
    }
}
