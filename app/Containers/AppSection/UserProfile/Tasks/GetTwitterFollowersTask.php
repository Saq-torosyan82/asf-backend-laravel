<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Ship\Exceptions\BadRequestException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetTwitterFollowersTask extends Task
{
    /**
     * @throws BadRequestException
     */
    public function run(string $userName): int
    {
        try {
            $data = file_get_contents(config('appSection-socialmedia.twitter.api.url') . '' . $userName);
            $parsed = json_decode($data, true);

            return isset($parsed[0]['followers_count']) ? $parsed[0]['followers_count'] : 0;

        } catch (Exception $exception) {
            throw new BadRequestException($exception->getMessage());
        }
    }
}
