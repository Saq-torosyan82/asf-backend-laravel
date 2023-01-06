<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\SocialMediaFollowersRepository;
use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class TransferSocialMediaLinksToSocialMediaFollowersTableTask extends Task
{
    protected UserProfileRepository $userProfileRepository;
    protected SocialMediaFollowersRepository $socialMediaFollowersRepository;

    public function __construct(UserProfileRepository $userProfileRepository, SocialMediaFollowersRepository $socialMediaFollowersRepository)
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->socialMediaFollowersRepository = $socialMediaFollowersRepository;
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(): void
    {
        $userProfiles = $this->userProfileRepository->findWhere([
            'group' => 'social_media'
        ]);

        foreach ($userProfiles as $profile) {
            try {
                $itemDoesntExist = $this->socialMediaFollowersRepository->where('link', $profile->value)->doesntExist();
                if($profile->value !== '' && $itemDoesntExist) {
                    $this->socialMediaFollowersRepository->create(
                        [
                            'user_id' => $profile->user_id,
                            'type' => $profile->key,
                            'link' => $profile->value,
                            'last_checked' => Carbon::now()->subDays(config('appSection-socialmedia.updateSocialFollowersOnceInXDays') + 1),

                        ]
                    );
                }

                $socialMediaLinks = $this->socialMediaFollowersRepository->get();

                foreach ($socialMediaLinks as $item) {
                    $itemDoesntExist = $this->userProfileRepository->where('value', $item->link)
                                            ->where('group', Group::SOCIAL_MEDIA)->doesntExist();
                    if($itemDoesntExist) {
                        $item->delete();
                    }
                }

            } catch (Exception $e) {
                throw new CreateResourceFailedException($e->getMessage());
            }
        }

    }
}
