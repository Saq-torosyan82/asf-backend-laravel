<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Ship\Parents\Tasks\Task;

class GetDealsByUserIdTask extends Task
{
    protected DealRepository $repository;

    public function __construct(DealRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId)
    {
        return $this->repository->findWhere([
            'user_id' => $userId
        ]);
    }
}
