<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\CountryRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindCountryByNameTask extends Task
{
    protected CountryRepository $repository;

    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($country_name)
    {
        try {
            return $this->repository->findByField('name', $country_name)->first();
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
