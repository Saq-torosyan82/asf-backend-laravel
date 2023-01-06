<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\UserSponsorship\Data\Repositories\ClubSponsorRepository;
use App\Ship\Parents\Tasks\Task;

class GetClubSponsorsByIdsTask extends Task
{
    protected ClubSponsorRepository $repository;

    public function __construct(ClubSponsorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $ids)
    {
        return $this->repository->orderBy('name', 'ASC')->findWhereIn('id', $ids);
    }
}
