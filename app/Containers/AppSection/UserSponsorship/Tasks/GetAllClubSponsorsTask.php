<?php

namespace App\Containers\AppSection\UserSponsorship\Tasks;

use App\Containers\AppSection\UserSponsorship\Data\Repositories\ClubSponsorRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllClubSponsorsTask extends Task
{
    protected ClubSponsorRepository $repository;

    public function __construct(ClubSponsorRepository $repository)
    {
       $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->orderBy('name', 'ASC')->all();
    }
}
