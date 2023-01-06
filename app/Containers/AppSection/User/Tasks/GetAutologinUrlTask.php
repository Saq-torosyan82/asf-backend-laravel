<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class GetAutologinUrlTask extends Task
{
    public function __construct()
    {
        // ..
    }

    public function run(User $user): string
    {
        $loginTokenRedirect = config('appSection-authentication.login_token_redirect');

        return "{$loginTokenRedirect}?token={$user->login_token}&uid={$user->getHashedKey()}";
    }
}
