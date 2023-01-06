<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetSportNewsTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByKeyTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetSportNewsDashboardAction extends Action
{
    public function run(Request $request)
    {
        $userId = $request->user()->id;
        $limit = config('appSection-system.news_count');
        $sports = $countries = [];
        $userProfile = app(FindUserProfileByKeyTask::class)->run($userId, Group::NEWS, Key::SPORTS_LIST);
        if ($userProfile) {
            $sports = json_decode($userProfile->value);
        }
        $userProfile = app(FindUserProfileByKeyTask::class)->run($userId, Group::NEWS, Key::COUNTRIES_LIST);
        if ($userProfile) {
            $countries = json_decode($userProfile->value);
        }

        return app(GetSportNewsTask::class)->addRequestCriteria()->order()->limit($limit)->sportIds($sports)->countryIds($countries)->run();

    }
}
