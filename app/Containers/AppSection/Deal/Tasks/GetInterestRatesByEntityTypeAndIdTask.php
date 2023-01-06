<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\InterestRateRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetInterestRatesByEntityTypeAndIdTask extends Task
{
    protected InterestRateRepository $repository;

    public function __construct(InterestRateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $type, int $entity_id)
    {
        try {
            return $this->repository->findWhere([
                'entity_type' => $type,
                'entity_id' => $entity_id
            ]);
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
