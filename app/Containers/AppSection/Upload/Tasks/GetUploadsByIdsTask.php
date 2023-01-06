<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\Upload\Data\Repositories\UploadRepository;
use App\Ship\Parents\Tasks\Task;

class GetUploadsByIdsTask extends Task
{
    protected UploadRepository $repository;

    public function __construct(UploadRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $upload_ids)
    {
        return $this->repository->findWhereIn('id', $upload_ids);
    }
}
