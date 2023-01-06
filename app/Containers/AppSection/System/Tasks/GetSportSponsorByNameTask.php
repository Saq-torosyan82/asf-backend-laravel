<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportSponsorRepository;
use App\Ship\Parents\Tasks\Task;

class GetSportSponsorByNameTask extends Task
{
    private SportSponsorRepository $repository;

    public function __construct(SportSponsorRepository $repository)
    {
       $this->repository = $repository;
    }

    public function run(string $name)
    {
        return $this->repository->where('name', $name)->first();
    }
}
