<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Criterias\IdsCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\LiveCriteria;
use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Ship\Criterias\OrderByCreationDateDescendingCriteria;
use App\Ship\Parents\Tasks\Task;

class GetLenderDealsTask extends Task
{
    protected DealRepository $repository;

    public function __construct(DealRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($user_id)
    {
        return app(GetLenderOffersTask::class)->addRequestCriteria()->offerBy($user_id)->accepted()->run();
    }
}
