<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportClubRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllSportCountriesTask extends Task
{
    protected SportClubRepository $repository;

    public function __construct(SportClubRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($sport_id)
    {
        return $this->repository->with('Country')
            ->findWhere(
            [
                'sport_id' => $sport_id,

            ]
        );
    }
}
