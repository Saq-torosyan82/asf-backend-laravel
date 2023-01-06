<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\LenderCriteriaRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindLenderCriteriaByIdTask extends Task
{
    protected LenderCriteriaRepository $repository;

    public function __construct(LenderCriteriaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            return $this->repository->find($id);
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
