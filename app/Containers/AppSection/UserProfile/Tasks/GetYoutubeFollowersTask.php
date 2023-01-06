<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Ship\Exceptions\BadRequestException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetYoutubeFollowersTask extends Task
{
    /**
     * @throws BadRequestException
     */
    public function run(string $chanelId): int
    {
        try {
            $googleClient  = app(GetGoogleClientTask::class)->run();
            $service = new \Google_Service_YouTube($googleClient);
            $queryParams = [
                'id' => $chanelId
            ];
            $listChannels = $service->channels->listChannels('snippet,contentDetails,statistics', $queryParams);

            return isset($listChannels->items[0]) ? $listChannels->items[0]->statistics->subscriberCount : 0;
        } catch (Exception $exception) {
            throw new BadRequestException($exception->getMessage());
        }

    }
}
