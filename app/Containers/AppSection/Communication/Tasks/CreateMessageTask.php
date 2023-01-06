<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\MessageRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateMessageTask extends Task
{
    protected MessageRepository $repository;

    public function __construct(MessageRepository $repository)
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
