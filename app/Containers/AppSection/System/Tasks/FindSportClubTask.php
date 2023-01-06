<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportClubRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindSportClubTask extends Task
{
    protected SportClubRepository $repository;

    public function __construct(SportClubRepository $repository)
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
