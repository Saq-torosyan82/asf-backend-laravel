<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\CreateOrUpdateUserProfileTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Traits\HashIdTrait;

class SaveNewsSportsAction extends Action
{
    use HashIdTrait;

    public function run(Request $request)
    {
        $userId = $request->user()->id;
        $sports = $request->sports;
        $data = [];
        if ($sports) {
            $sports = !is_array($sports) ? [$sports] : $sports;
            $ids = [];
            foreach ($sports as $sport) {
                $id = $this->decode($sport);
                if (!empty($id)) {
                    $ids[] = $id;
                }
            }
            $result = app(CreateOrUpdateUserProfileTask::class)->run($userId, Group::NEWS, Key::SPORTS_LIST, json_encode($ids));
            if ($result) {
                $result = json_decode($result->value);
                foreach ($result as $res) {
                    $data[] = $this->encode($res);
                }
            }
        }
        return $data;
    }
}
