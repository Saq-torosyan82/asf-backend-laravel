<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\CountryRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetCountryByIdTask extends Task
{
    protected CountryRepository $repository;

    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundException
     */
    public function run($id)
    {
        try {
            return $this->repository->findByField('id', $id)->first();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
