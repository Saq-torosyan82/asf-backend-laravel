<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Models\SocialMediaFollowers;
use App\Ship\Parents\Tasks\Task;

class GetFollowersForSnapshotTask extends Task
{
    protected SocialMediaFollowers $repository;

    public function __construct(SocialMediaFollowers $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $user_id)
    {
        $groupedList = [
            [
                'label' => ucfirst(Key::INSTAGRAM),
                'value' => null,
            ],
            [
                'label' => ucfirst(Key::FACEBOOK),
                'value' => null,
            ],
            [
                'label' => ucfirst(Key::TWITTER),
                'value' => null,
            ],
            [
                'label' => ucfirst(Key::YOUTUBE),
                'value' => null,
            ]
        ];
        $res = $this->repository->where('user_id', $user_id)->get();
        if (!$res->isEmpty()) {
            foreach ($res as $row) {
                $key = array_search(ucfirst($row->type), array_column($groupedList, 'label'));
                if ($key !== false) {
                    $groupedList[$key]['value'] = $row->nb_followers;
                }
            }
        }
        return $groupedList;
    }

}
