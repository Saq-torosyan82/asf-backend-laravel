<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Tasks\RapidApiConnectionTask;
use App\Ship\Exceptions\BadRequestException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetInstagramFollowersTask extends Task
{

    /**
     * @throws BadRequestException
     */
    public function run(string $userName): int
    {
        try {
            $instagramInfo = app(RapidApiConnectionTask::class)->run(
                config('appSection-socialmedia.rapidApi.instagram.url'),
                [
                    'username' => $userName
                ],
                [
                    'x-rapidapi-host' => config('appSection-socialmedia.rapidApi.instagram.x-rapidapi-host'),
                    'x-rapidapi-key' => config('appSection-socialmedia.rapidApi.instagram.x-rapidapi-key'),
                ]
            );

            if (isset($instagramInfo->edge_followed_by)) {
                return $instagramInfo->edge_followed_by->count;
            }

            if (isset($instagramInfo->status) && ($instagramInfo->status == 'fail')) {
                throw new Exception($instagramInfo->message);
            }

            if(isset($instagramInfo->message)) {
                throw new Exception($instagramInfo->message);
            }

            return 0;
        } catch (Exception $exception) {
            throw new BadRequestException($exception->getMessage());
        }

    }
}
