<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Tasks\RapidApiConnectionTask;
use App\Containers\AppSection\UserProfile\Tasks\TransferSocialMediaLinksToSocialMediaFollowersTableTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\CreateResourceFailedException;

class TransferSocialMediaLinksAction extends Action
{
    /**
     * @throws CreateResourceFailedException
     */
    public function run(): void
    {
        app(TransferSocialMediaLinksToSocialMediaFollowersTableTask::class)->run();
    }
}
