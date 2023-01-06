<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportBrandRepository;
use App\Ship\Parents\Tasks\Task;

class GetSportBrandByNameTask extends Task
{
    private SportBrandRepository $repository;

    public function __construct(SportBrandRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $name)
    {
        return $this->repository->where('name', $name)->first();
    }
}
