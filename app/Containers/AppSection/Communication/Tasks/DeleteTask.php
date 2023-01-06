<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\CommunicationRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteTask extends Task
{
    protected CommunicationRepository $repository;

    public function __construct(CommunicationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id): ?int
    {
        try {
            return $this->repository->delete($id);
        }
        catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
