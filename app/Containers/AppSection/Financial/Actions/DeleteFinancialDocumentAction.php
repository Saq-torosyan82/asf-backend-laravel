<?php

namespace App\Containers\AppSection\Financial\Actions;

use App\Containers\AppSection\Financial\Tasks\DeleteFinancialDocumentTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeleteFinancialDocumentAction extends Action
{
    public function run(Request $request)
    {
        return app(DeleteFinancialDocumentTask::class)->run($request->id);
    }
}
