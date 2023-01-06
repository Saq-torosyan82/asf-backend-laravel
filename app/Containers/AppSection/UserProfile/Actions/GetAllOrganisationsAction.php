<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\System\Tasks\GetAllSportClubsTask;
use App\Containers\AppSection\Upload\Tasks\GetUploadsByIdsTask;
use App\Containers\AppSection\User\Tasks\GetUsersByIdsTask;
use App\Containers\AppSection\User\Tasks\GetUsersByParentIdsTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\GetUsersProfileByKeyAndValueTask;
use App\Containers\AppSection\UserProfile\Tasks\GetUsersProfileByKeyTask;
use App\Ship\Parents\Actions\Action;

class GetAllOrganisationsAction extends Action
{
    use HashIdTrait;

    public function run($encode_id = false)
    {
        $profiles = app(GetUsersProfileByKeyAndValueTask::class)->run(
            Group::ACCOUNT,
            Key::BORROWER_TYPE,
            BorrowerType::CORPORATE
        );
        $data = [];
        foreach ($profiles as $row) {
            $data[$row->user_id] =
                [
                    'id' => $row->user_id,
                    'users' => [],
                ];
        }

        // get all children
        $res = app(GetUsersByParentIdsTask::class)->run(array_keys($data));
        foreach ($res as $row) {
            if (!isset($data[$row->parent_id])) {
                continue;
            }
            $data[$row->parent_id]['users'][] = [
                'id' => $encode_id ? $this->encode($row->id) : $row->id,
                'name' => $row->first_name . ' ' . $row->last_name,
                'email' => $row->email
            ];
        }


        // get all avatars
        $res = app(GetUsersProfileByKeyTask::class)->run(Group::USER, Key::AVATAR, array_keys($data));
        $avatars = [];
        foreach ($res as $row) {
            $avatars[$row->user_id] = $row->value;
        }


        // get download links
        $res = app(GetUploadsByIdsTask::class)->run(array_values($avatars));
        $downloads = [];
        foreach ($res as $row) // get bulk files
        {
            $downloads[$row->user_id] = downloadUrl($row->uuid);
        }

        // get bulk users
        $res = app(GetUsersByIdsTask::class)->run(array_keys($data));
        $users = [];
        foreach ($res as $row) {
            // remove inactive users
            if (!$row->is_active && isset($data[$row->id])) {
                unset($data[$row->id]);
            }
            $users[$row->id] = $row;
        }

        // add name and avatar
        foreach ($data as $user_id => $row) {
            $data[$user_id]['name'] = isset($users[$user_id]) ? $users[$user_id]->first_name . ' ' . $users[$user_id]->last_name : '';
            $data[$user_id]['avatar'] = isset($downloads[$user_id]) ? $downloads[$user_id] : '';
            if ($encode_id) {
                $data[$user_id]['id'] = $this->encode($user_id);
            }
        }

        return array_values($data);
    }
}
