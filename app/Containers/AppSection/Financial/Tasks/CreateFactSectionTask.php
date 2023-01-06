<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FactSectionRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateFactSectionTask extends Task
{
    protected FactSectionRepository $repository;

    public function __construct(FactSectionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data)
    {
        try {
            return $this->repository->create($data);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }
    }
}
