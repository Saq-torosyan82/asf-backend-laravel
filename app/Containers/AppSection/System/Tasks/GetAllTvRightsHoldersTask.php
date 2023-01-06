<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\TvRightsHolderRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllTvRightsHoldersTask extends Task
{
    protected TvRightsHolderRepository $repository;

    public function __construct(TvRightsHolderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->all();
    }
}
