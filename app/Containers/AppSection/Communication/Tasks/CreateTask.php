<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\CommunicationRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateTask extends Task
{
    protected CommunicationRepository $repository;

    public function __construct(CommunicationRepository $repository)
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
