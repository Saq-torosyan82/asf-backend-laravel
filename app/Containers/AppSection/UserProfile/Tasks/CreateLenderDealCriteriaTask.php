<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\LenderDealCriteriaRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateLenderDealCriteriaTask extends Task
{
    protected LenderDealCriteriaRepository $repository;

    public function __construct(LenderDealCriteriaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $lenderId, int $type, int $minAmount, int $maxAmount, int $minTenor, int $maxTenor, int $minInterestRate, int $interestRange, $note = '')
    {
        try {
            return $this->repository->create([
                'lender_id' => $lenderId,
                'type' => $type,
                'min_amount' => $minAmount,
                'max_amount' => $maxAmount,
                'min_tenor' => $minTenor,
                'max_tenor' => $maxTenor,
                'min_interest_rate' => $minInterestRate,
                'interest_range' => $interestRange,
                'note' => $note
            ]);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }
    }
}
