<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\User\Tasks\CheckPasswordSetTask;
use App\Containers\AppSection\User\Tasks\ChangePasswordTask;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\ConflictException;
use Illuminate\Support\Facades\Hash;
use App\Ship\Exceptions\ValidationFailedException;


class ChangePasswordAction extends Action
{
    public function run(Request $request)
    {
        $user = $request->user();
        $isLender = $user->FindUserRoleByName(PermissionType::LENDER) != null;

        if(!$isLender || ($isLender && app(CheckPasswordSetTask::class)->run($user->id))) {
            if(!$request->old_password || $request->old_password == '')
                throw new ConflictException('The old password is missing!');

            $isLogged = Hash::check($request->old_password, $user->password);
            if(!$isLogged) 
                throw new ConflictException('The old password is not correct!');

        }

        if($request->password != $request->password_confirmation) 
            throw new ValidationFailedException('The new passwords don`t match!');

        app(ChangePasswordTask::class)->run($user->email, $request->password);
    }
}
