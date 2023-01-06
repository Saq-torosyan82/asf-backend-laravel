<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\System\Tasks\GetAllCountriesTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByKeyTask;
use App\Ship\Parents\Actions\Action;

class GetNewsCountriesAction extends Action
{
    use HashIdTrait;

    public function run($request)
    {
        $profile = app(FindUserProfileByKeyTask::class)->run(
            $request->user()->id,
            Group::NEWS,
            Key::COUNTRIES_LIST
        );
        $data = [];
        if ($profile != null) {
            $countries_list = json_decode($profile->value);
            $countries = app(GetAllCountriesTask::class)->run();
            $countryData = [];
            foreach ($countries as $country) {
                $countryData[$country->id] = $country->name;
            }
            foreach ($countries_list as $country_id) {
                if (!isset($countryData[$country_id])) {
                    continue;
                }
                $data[] = [
                    'id'   => $this->encode($country_id),
                    'name' => $countryData[$country_id]
                ];
            }
        }
        return $data;
    }
}