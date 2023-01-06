<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\CountryRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllClubCountriesTask extends Task
{
    protected CountryRepository $repository;

    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->has("Clubs")->get();
    }
}
