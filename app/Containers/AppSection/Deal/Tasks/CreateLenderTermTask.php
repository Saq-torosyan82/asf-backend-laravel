<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\LenderTermRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateLenderTermTask extends Task
{
    protected LenderTermRepository $repository;

    public function __construct(LenderTermRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data)
    {
        try {
            return $this->repository->create($data);
        }
        catch (Exception $exception) {
            dd($exception->getMessage());
            throw new CreateResourceFailedException();
        }
    }
}
