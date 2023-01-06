<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FactValueRepository;
use App\Ship\Parents\Tasks\Task;

class GetFactsByIdTask extends Task
{
    protected FactValueRepository $repository;

    public function __construct(FactValueRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $ids)
    {
        return $this->repository->findWhereIn('id', $ids);
    }
}
