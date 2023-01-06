<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportClubRepository;
use App\Ship\Parents\Tasks\Task;

class GetSportClubByNameTask extends Task
{
    private SportClubRepository $repository;

    public function __construct(SportClubRepository $repository)
    {
       $this->repository = $repository;
    }

    public function run(string $name)
    {
        return $this->repository->where('name', $name)->first();
    }
}
