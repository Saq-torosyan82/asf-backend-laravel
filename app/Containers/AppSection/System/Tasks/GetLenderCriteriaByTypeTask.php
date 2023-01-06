<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\LenderCriteriaRepository;
use App\Ship\Parents\Tasks\Task;

class GetLenderCriteriaByTypeTask extends Task
{
    protected LenderCriteriaRepository $repository;

    public function __construct(LenderCriteriaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($type)
    {
        return $this->repository->where('type', $type)->get();
    }
}
