<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Tasks\GetAllUploadsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllUploadsAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllUploadsTask::class)->addRequestCriteria()->run();
    }
}
