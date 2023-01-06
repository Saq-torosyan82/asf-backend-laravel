<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Http;

class RapidApiConnectionTask extends Task
{
    public function __construct()
    {
        // ..
    }

    public function run(string $url, array $queryData, array $headers)
    {
        $response  = Http::withHeaders($headers)->get($url, $queryData);

        return json_decode($response->body());
    }
}
