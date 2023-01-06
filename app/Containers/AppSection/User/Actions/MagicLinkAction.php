<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Containers\AppSection\User\Mails\MagicLinkMail;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Mail;

class MagicLinkAction extends Action
{
    public function run(Request $request)
    {
        $user = app(FindUserByEmailTask::class)->run($request->email);
        if($user == null) throw new NotFoundException('User not found!');

        $tokenExpiration = config('appSection-authentication.login_magic_link_token_expiration');
        app(SetLoginTokenSubAction::class)->run($user->id, 10);

        Mail::send(new MagicLinkMail($user));
    }
}
