<?php

namespace App\Containers\AppSection\UserSponsorship\Tasks;

use App\Containers\AppSection\UserSponsorship\Data\Repositories\ClubSponsorRepository;
use App\Ship\Parents\Tasks\Task;

class GetClubSponsorByNameTask extends Task
{

    protected ClubSponsorRepository $repository;

    public function __construct(ClubSponsorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $name)
    {
        return $this->repository->where('name', $name)->first();
    }
}
