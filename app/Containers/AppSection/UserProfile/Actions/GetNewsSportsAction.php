<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\System\Tasks\GetAllSportsTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByKeyTask;
use App\Ship\Parents\Actions\Action;

class GetNewsSportsAction extends Action
{
    use HashIdTrait;

    public function run($request)
    {
        $profile = app(FindUserProfileByKeyTask::class)->run(
            $request->user()->id,
            Group::NEWS,
            Key::SPORTS_LIST
        );
        $data = [];
        if ($profile != null) {
            $sports_list = json_decode($profile->value);
            $sports = app(GetAllSportsTask::class)->run();
            $sportData = [];
            foreach ($sports as $sport) {
                $sportData[$sport->id] = $sport->name;
            }
            foreach ($sports_list as $sport_id) {
                if (!isset($sportData[$sport_id])) {
                    continue;
                }
                $data[] = [
                    'id'   => $this->encode($sport_id),
                    'name' => $sportData[$sport_id]
                ];
            }
        }
        return $data;
    }
}