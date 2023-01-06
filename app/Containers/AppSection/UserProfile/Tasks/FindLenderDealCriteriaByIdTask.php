<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\LenderDealCriteriaRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindLenderDealCriteriaByIdTask extends Task
{
    protected LenderDealCriteriaRepository $repository;

    public function __construct(LenderDealCriteriaRepository $repository)
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
