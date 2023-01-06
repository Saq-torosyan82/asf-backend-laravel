<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportLeagueRepository;
use App\Containers\AppSection\System\Models\SportLeague;
use App\Ship\Parents\Tasks\Task;

class GetSportLeagueByNameTask extends Task
{
    protected SportLeagueRepository $repository;

    public function __construct(SportLeagueRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $name)
    {
        return $this->repository->where('name', $name)->first();
    }
}
