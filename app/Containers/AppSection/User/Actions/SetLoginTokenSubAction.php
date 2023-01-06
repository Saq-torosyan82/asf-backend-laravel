<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Parents\Actions\SubAction;
use Carbon\Carbon;

class SetLoginTokenSubAction extends SubAction
{
    public function run(int $userId, $loginTokenExpiration): string
    {
        $loginTokenSize = config('appSection-authentication.login_token_size');
        $loginToken = bin2hex(random_bytes($loginTokenSize / 2));
        $expirationDate = Carbon::now()->addMinutes($loginTokenExpiration);

        app(UpdateUserTask::class)->run([
            'login_token' => $loginToken,
            'login_token_expire' => $expirationDate
        ], $userId);

        return $loginToken;
    }
}
