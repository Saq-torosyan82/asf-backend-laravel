<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Ship\Exceptions\BadRequestException;
use App\Ship\Parents\Tasks\Task;

class GetLinkedinFollowersTask extends Task
{
    public function run(string $companyId): int
    {
        try {
            $linkedinInfo = app(RapidApiConnectionTask::class)->run(
                config('appSection-socialmedia.rapidApi.linkedin.url'),
                [
                    'vanity_name' => $companyId
                ],
                [
                    'x-rapidapi-host' => config('appSection-socialmedia.rapidApi.linkedin.x-rapidapi-host'),
                    'x-rapidapi-key' => config('appSection-socialmedia.rapidApi.linkedin.x-rapidapi-key'),
                ]
            );

            if(is_null($linkedinInfo)) {
                throw new \Exception('no data returned by api');
            }


            return (int)$linkedinInfo->social_followers;
        } catch (Exception $exception) {
            throw new BadRequestException($exception->getMessage());
        }
    }
}
