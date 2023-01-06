<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Ship\Exceptions\BadRequestException;
use App\Ship\Parents\Tasks\Task;

class GetFacebookFollowersTask extends Task
{
    public function run(string $link): int
    {
        try {
            $facebookInfo = app(RapidApiConnectionTask::class)->run(
                config('appSection-socialmedia.rapidApi.facebook.url'),
                [
                    'url' => $link
                ],
                [
                    'x-rapidapi-host' => config('appSection-socialmedia.rapidApi.facebook.x-rapidapi-host'),
                    'x-rapidapi-key' => config('appSection-socialmedia.rapidApi.facebook.x-rapidapi-key'),
                ]
            );

            if (!isset($facebookInfo->description) || !$facebookInfo->description) {
                throw new \Exception('no data returned by api');
            }

            if (preg_match('/([0-9,]*) likes/', $facebookInfo->description, $matches)) {
                return (int)str_replace(",", "", $matches[1]);
            }

            throw new \Exception('no likes found on page');
        } catch (Exception $exception) {
            throw new BadRequestException($exception->getMessage());
        }
    }
}
