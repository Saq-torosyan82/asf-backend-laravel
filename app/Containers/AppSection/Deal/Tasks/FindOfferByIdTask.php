<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealOfferRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindOfferByIdTask extends Task
{
    protected DealOfferRepository $repository;

    public function __construct(DealOfferRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            return $this->repository->find($id);
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
