<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\Upload\Data\Repositories\UploadRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllUploadsTask extends Task
{
    protected UploadRepository $repository;

    public function __construct(UploadRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->paginate();
    }
}
