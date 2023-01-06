<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\CreateOrUpdateUserProfileTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Traits\HashIdTrait;

class SaveNewsCountriesAction extends Action
{
    use HashIdTrait;

    public function run(Request $request)
    {
        $userId = $request->user()->id;
        $countries = $request->countries;
        $data = [];
        if ($countries) {
            $countries = !is_array($countries) ? [$countries] : $countries;
            $ids = [];
            foreach ($countries as $country) {
                $id = $this->decode($country);
                if (!empty($id)) {
                    $ids[] = $id;
                }
            }
            $result = app(CreateOrUpdateUserProfileTask::class)->run($userId, Group::NEWS, Key::COUNTRIES_LIST, json_encode($ids));
            if ($result) {
                $result = json_decode($result->value);
                foreach($result as $res) {
                    $data[] = $this->encode($res);
                }
            }
        }
        return $data;
    }
}
