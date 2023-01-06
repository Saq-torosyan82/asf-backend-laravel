<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Ship\Parents\Tasks\Task;

class GetGoogleClientTask extends Task
{

    public function run() : \Google_Client
    {
       $client = new \Google_Client();
       $client->setApplicationName("Google API");
       $client->setDeveloperKey(config('appSection-socialmedia.googleApi.developerKey'));

       return $client;
    }
}
