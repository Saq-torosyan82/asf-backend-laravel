<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\Upload\Data\Repositories\UploadRepository;
use App\Containers\AppSection\Upload\Models\Upload;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Ramsey\Uuid\Uuid;

class FindUploadByUuidTask extends Task
{
    protected UploadRepository $repository;

    public function __construct(UploadRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($uuid)
    {
        try {
            return $this->repository->whereUuid($uuid)->first();
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
