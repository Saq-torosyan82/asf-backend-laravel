<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportBrandRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllSportBrandsTask extends Task
{
    protected SportBrandRepository $repository;

    public function __construct(SportBrandRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->all();
    }
}
