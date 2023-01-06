<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Parents\Tasks\Task;

class GetChildUsersByParentIdTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $userIds)
    {
        $query = $this->repository->with('UserProfile');

        return $query->findWhereIn('parent_id', $userIds);
    }
}

