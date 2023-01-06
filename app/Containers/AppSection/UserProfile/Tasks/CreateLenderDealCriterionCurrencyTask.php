<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\LenderDealCriterionCurrencyRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateLenderDealCriterionCurrencyTask extends Task
{
    protected LenderDealCriterionCurrencyRepository $repository;

    public function __construct(LenderDealCriterionCurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $criterionId, int $currencyId)
    {
        try {
            return $this->repository->create([
                'criterion_id' => $criterionId,
                'currency_id' => $currencyId
            ]);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
