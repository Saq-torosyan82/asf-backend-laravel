<?php

namespace App\Containers\AppSection\Rate\Actions;

use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllRatesAction extends Action
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Apiato\Core\Exceptions\CoreInternalErrorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(Request $request)
    {
        return app(GetAllRatesTask::class)->addRequestCriteria()->run();
    }
}
