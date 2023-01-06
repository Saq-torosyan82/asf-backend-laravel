<?php

namespace App\Containers\AppSection\Financial\Actions\ImportClubData;

use App\Containers\AppSection\Financial\Tasks\ImportClubData\FinancialDataNewTask;
use App\Ship\Parents\Actions\Action;

class FinancialDataNewAction extends Action
{
    public function run($folder)/*: Financial*/
    {
        echo "\nRunning FinancialDataNewAction for folder: [$folder]";
        return app(FinancialDataNewTask::class)->run($folder);
    }
}
