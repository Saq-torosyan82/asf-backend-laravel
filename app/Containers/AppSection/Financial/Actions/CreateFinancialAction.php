<?php

namespace App\Containers\AppSection\Financial\Actions;

use App\Containers\AppSection\Financial\Models\Financial;
use App\Containers\AppSection\Financial\Tasks\CreateFinancialTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class CreateFinancialAction extends Action
{
    public function run(Request $request): Financial
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(CreateFinancialTask::class)->run($data);
    }
}
