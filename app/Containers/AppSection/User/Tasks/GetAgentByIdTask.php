<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;

class GetAgentByIdTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($userId)
    {
        try {
            return $this->repository->where('id', $userId)->getAgent()->first();
        }catch (\Exception $exception) {
            throw new NotFoundException($exception->getMessage());
        }
    }
}
