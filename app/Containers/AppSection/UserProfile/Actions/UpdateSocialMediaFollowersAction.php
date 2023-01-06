<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\GetFacebookFollowersTask;
use App\Containers\AppSection\UserProfile\Tasks\GetInstagramFollowersTask;
use App\Containers\AppSection\UserProfile\Tasks\GetLinkedinFollowersTask;
use App\Containers\AppSection\UserProfile\Tasks\GetSocialMediaAccountsTask;
use App\Containers\AppSection\UserProfile\Tasks\GetTwitterFollowersTask;
use App\Containers\AppSection\UserProfile\Tasks\GetYoutubeFollowersTask;
use App\Ship\Parents\Actions\Action;
use Carbon\Carbon;
use App\Ship\Exceptions\BadRequestException;
use Illuminate\Support\Facades\Log;

class UpdateSocialMediaFollowersAction extends Action
{
    /**
     * @throws BadRequestException
     */
    public function run(): void
    {
        $socialMediaItems = app(GetSocialMediaAccountsTask::class)->run();

        foreach ($socialMediaItems as $item) {
            try {
                $followers = match ($item->type) {
                    Key::INSTAGRAM => app(GetInstagramFollowersTask::class)->run($this->getId($item->link)),
                    Key::FACEBOOK => app(GetFacebookFollowersTask::class)->run($this->cleanLink($item->link)),
                    Key::YOUTUBE => app(GetYoutubeFollowersTask::class)->run($this->getYoutubeId($item->link)),
                    Key::TWITTER => app(GetTwitterFollowersTask::class)->run($this->getId($item->link)),
                    Key::LINKEDIN => app(GetLinkedinFollowersTask::class)->run($this->getId($item->link)),
                    default => $item->nb_followers,
                };

                Log::info($item->link . ': Followers: ' . $followers);

                $item->update([
                    'nb_followers' => $followers,
                    'last_checked' => Carbon::now()

                ]);
            } catch (\Exception $exception) {
                Log::error($item->link . ': ' . $exception->getMessage());
            }
        }
    }

    private function getYoutubeId($link): ?string
    {
        $explodedLink = explode('/', $link);
        return $explodedLink[count($explodedLink) - 1] ?? null;
    }

    /**
     * @param $link
     * @return string|null
     */
    private function getId($link): ?string
    {
        $link = $this->cleanLink($link);

        $explodedLink = explode('/', $link);
        return $explodedLink[count($explodedLink) - 1] ?? null;
    }

    private function cleanLink($link)
    {
        // remove all characters after ?
        $link = strtok($link, '?');
        // remove last character if it is /
        return trim($link, '/');
    }
}
