<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindFinancialsTask extends Task
{
    protected FinancialRepository $repository;

    public function __construct(FinancialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $filters)
    {
        try {
            return $this->repository->orderBy('season_id','DESC')->findWhere($filters);
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
