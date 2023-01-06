<?php

namespace App\Containers\AppSection\Financial\Actions\ImportClubData;

use App\Containers\AppSection\Financial\Tasks\ImportClubData\FinancialDataTask;
use App\Ship\Parents\Actions\Action;

class FinancialDataAction extends Action
{
    public function run($folder)/*: Financial*/
    {
        /*
        $data = $request->sanitizeInput([
            // add your request data here
        ]);
        */

        echo "\nRunning FinancialDataAction for folder: [$folder]";
        $error = '';
        return app(FinancialDataTask::class)->run($folder, $error);
    }
}
