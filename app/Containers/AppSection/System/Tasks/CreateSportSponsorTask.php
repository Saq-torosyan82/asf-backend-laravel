<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportSponsorRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateSportSponsorTask extends Task
{
    protected SportSponsorRepository $repository;

    public function __construct(SportSponsorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($row)
    {
        try {
            return $this->repository->create($row);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }
    }
}
