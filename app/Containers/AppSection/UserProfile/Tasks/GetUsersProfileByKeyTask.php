<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetUsersProfileByKeyTask extends Task
{
    protected UserProfileRepository $repository;

    public function __construct(UserProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $group, string $key, array $user_ids)
    {
        try {
            return $this->repository->findWhereIn('user_id', $user_ids)
                ->where('group', '=', $group)
                ->where('key', '=', $key)
                ->all();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
