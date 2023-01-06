<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllFinancialsTask extends Task
{
    protected FinancialRepository $repository;

    public function __construct(FinancialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->paginate();
    }
}
