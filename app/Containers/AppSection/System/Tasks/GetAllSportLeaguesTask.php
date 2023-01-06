<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportLeagueRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllSportLeaguesTask extends Task
{
    protected SportLeagueRepository $repository;

    public function __construct(SportLeagueRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->all();
    }
}
