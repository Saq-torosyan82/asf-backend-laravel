<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllLenderDealsTask extends Task
{
    protected DealRepository $repository;

    public function __construct(DealRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($user_id)
    {
        return app(GetAllLenderOffersTask::class)->addRequestCriteria()->offerBy($user_id)->notRejected()->ordered()->run();
    }
}
