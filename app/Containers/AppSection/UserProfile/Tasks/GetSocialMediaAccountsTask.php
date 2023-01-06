<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\SocialMediaFollowersRepository;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class GetSocialMediaAccountsTask extends Task
{
    protected SocialMediaFollowersRepository $socialMediaFollowersRepository;

    public function __construct(SocialMediaFollowersRepository $socialMediaFollowersRepository)
    {
        $this->socialMediaFollowersRepository = $socialMediaFollowersRepository;
    }

    public function run()
    {
        return $this->socialMediaFollowersRepository
                    ->whereDate('last_checked', '<=', Carbon::now()
                        ->subDays(config('appSection-socialmedia.updateSocialFollowersOnceInXDays')))->get();
    }
}
