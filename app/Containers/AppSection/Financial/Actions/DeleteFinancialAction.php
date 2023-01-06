<?php

namespace App\Containers\AppSection\Financial\Actions;

use App\Containers\AppSection\Financial\Tasks\DeleteFinancialTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeleteFinancialAction extends Action
{
    public function run(Request $request)
    {
        return app(DeleteFinancialTask::class)->run($request->id);
    }
}
