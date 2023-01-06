<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportLeagueRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindSportLeagueTask extends Task
{
    protected SportLeagueRepository $repository;

    public function __construct(SportLeagueRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $filters)
    {
        try {
            return $this->repository->findWhere($filters);
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
