<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FactValueRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateOrUpdateFactValueTask extends Task
{
    protected FactValueRepository $repository;

    public function __construct(FactValueRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $filters, array $data)
    {
        try {
            $this->repository->updateOrCreate($filters, $data);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }
    }
}
