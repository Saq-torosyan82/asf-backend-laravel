<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\LenderCriteriaRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllLenderCriteriaTask extends Task
{
    protected LenderCriteriaRepository $repository;

    public function __construct(LenderCriteriaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->orderBy('type')->orderBy('index')->get();
    }
}
