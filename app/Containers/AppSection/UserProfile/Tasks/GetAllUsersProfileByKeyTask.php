<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetAllUsersProfileByKeyTask extends Task
{
    protected UserProfileRepository $repository;

    public function __construct(UserProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $group, string $key)
    {
        try {
            return $this->repository->findWhere(
                [
                    'group' => $group,
                    'key' => $key
                ]
            )
                ->all();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
