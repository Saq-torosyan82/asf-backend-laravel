<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindUserProfileByKeyTask extends Task
{
    protected UserProfileRepository $repository;

    public function __construct(UserProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId, string $group, string $key)
    {
        $filters = [
            'user_id' => $userId,
            'group' => $group,
            'key' => $key,
        ];

        try {
            return $this->repository->findWhere($filters)->first();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
