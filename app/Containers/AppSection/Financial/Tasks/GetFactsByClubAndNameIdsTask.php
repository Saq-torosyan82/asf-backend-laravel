<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FactValueRepository;
use App\Ship\Parents\Tasks\Task;

class GetFactsByClubAndNameIdsTask extends Task
{
    protected FactValueRepository $repository;

    public function __construct(FactValueRepository $factValueRepository)
    {
        $this->repository = $factValueRepository;
    }

    public function run(int $club_id, array $name_ids)
    {
        return $this->repository->findWhereIn('fact_name_id', $name_ids)
            ->where('club_id', '=', $club_id)
            ->all();
    }
}
