<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\LenderDealCriterionSportRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateLenderDealCriterionSportTask extends Task
{
    protected LenderDealCriterionSportRepository $repository;

    public function __construct(LenderDealCriterionSportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $criterionId, int $sportId)
    {
        try {
            return $this->repository->create([
                'criterion_id' => $criterionId,
                'sport_id' => $sportId
            ]);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
