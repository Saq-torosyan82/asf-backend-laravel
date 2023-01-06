<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\LenderDealCriterionCountryRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateLenderDealCriterionCountryTask extends Task
{
    protected LenderDealCriterionCountryRepository $repository;

    public function __construct(LenderDealCriterionCountryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $criterionId, int $countryId)
    {
        try {
            return $this->repository->create([
                'criterion_id' => $criterionId,
                'country_id' => $countryId
            ]);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
