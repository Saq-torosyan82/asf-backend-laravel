<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\LenderDealCriteriaRepository;
use App\Ship\Parents\Tasks\Task;

class GetLenderDealCriteriaTask extends Task
{
    protected LenderDealCriteriaRepository $repository;

    public function __construct(LenderDealCriteriaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($user_id)
    {
        return $this->repository->where('lender_id', $user_id)->get();
    }
}
