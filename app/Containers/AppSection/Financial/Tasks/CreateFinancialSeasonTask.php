<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialSeasonRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateFinancialSeasonTask extends Task
{
    protected FinancialSeasonRepository $repository;

    public function __construct(FinancialSeasonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data)
    {
        try {
            return $this->repository->create($data);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
