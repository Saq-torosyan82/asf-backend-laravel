<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\BorrowerTypeRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllBorrowerTypesTask extends Task
{
    protected BorrowerTypeRepository $repository;

    public function __construct(BorrowerTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->orderBy('index')->get();
    }
}
