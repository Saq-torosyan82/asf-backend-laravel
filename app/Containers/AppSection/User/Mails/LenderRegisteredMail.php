<?php

namespace App\Containers\AppSection\User\Mails;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class LenderRegisteredMail extends Mail implements ShouldQueue
{
    use Queueable;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): self
    {
        $loginTokenRedirect = config('appSection-authentication.login_token_redirect');
        $fullUrl = "{$loginTokenRedirect}?token={$this->user->login_token}&uid={$this->user->getHashedKey()}";

        return $this->view('appSection@user::lender-registered')
            ->to($this->user->email, $this->user->name)
            ->with([
                'name' => $this->user->name,
                'email' => $this->user->email,
                'autologin_url' => $fullUrl
            ]);
    }
}
