<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\BorrowerTypeRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateBorrowerTypeTask extends Task
{
    protected BorrowerTypeRepository $repository;

    public function __construct(BorrowerTypeRepository $repository)
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
