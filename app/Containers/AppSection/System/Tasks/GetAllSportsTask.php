<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllSportsTask extends Task
{
    protected SportRepository $repository;

    public function __construct(SportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->all();
    }
}
