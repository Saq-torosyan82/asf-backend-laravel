<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetDealsByUsersIdsTask extends Task
{
    protected DealRepository $repository;

    public function __construct(DealRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $userIds)
    {
        try {
            return $this->repository->findWhereIn('user_id', $userIds);
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
