<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\AttachementRepository as AttachementRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateAttachementTask extends Task
{
    protected AttachementRepository $repository;

    public function __construct(AttachementRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
