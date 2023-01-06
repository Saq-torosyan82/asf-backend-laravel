<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Exceptions\InvalidResetTokenException;
use App\Containers\AppSection\User\Exceptions\InvalidUserException;
use App\Containers\AppSection\User\Exceptions\PasswordsDoesntMatchException;
use App\Containers\AppSection\User\UI\API\Requests\ResetPasswordRequest;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction extends Action
{
    public function run(ResetPasswordRequest $request): void
    {
        $sanitizedData = $request->sanitizeInput(
            [
                'email',
                'token',
                'password',
                'password_confirmation'
            ]
        );


        if ($sanitizedData['password'] != $sanitizedData['password_confirmation']) {
            throw new PasswordsDoesntMatchException();
        }

        try {
            $res = Password::broker()->reset(
                $sanitizedData,
                function ($user, $password) {
                    $data = [
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ];

                    if (!$user->email_verified_at) {
                        $data['email_verified_at'] = Carbon::now();
                    }
                    $user->forceFill($data)->save();
                }
            );
            if ($res == Password::PASSWORD_RESET) {
                return;
            }
        } catch (Exception $e) {
            throw new InternalErrorException();
        }

        if ($res == Password::INVALID_TOKEN) {
            throw new InvalidResetTokenException();
        } elseif ($res == Password::INVALID_USER) {
            throw new InvalidUserException();
        }

        throw new InternalErrorException();
    }
}
