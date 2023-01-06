<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FactIntervalRepository;
use App\Ship\Parents\Tasks\Task;

class GetFactIntervalsTask extends Task
{
    protected FactIntervalRepository $repository;

    public function __construct(FactIntervalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->all();
    }
}
