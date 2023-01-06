<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportSponsorRepository;
use App\Ship\Parents\Tasks\Task;

class GetSportSponsorsByIdsTask extends Task
{
    protected SportSponsorRepository $repository;

    public function __construct(SportSponsorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $ids)
    {
        return $this->repository->findWhereIn('id', $ids);
    }
}
