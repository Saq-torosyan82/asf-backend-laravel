<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\CommunicationRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateTask extends Task
{
    protected CommunicationRepository $repository;

    public function __construct(CommunicationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data)
    {
        try {
            return $this->repository->update($data, $id);
        }
        catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
