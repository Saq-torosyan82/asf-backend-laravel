<?php

namespace App\Containers\AppSection\Financial\Actions\ImportClubData;

use App\Containers\AppSection\Financial\Tasks\ImportClubData\FactDataNewTask;
use App\Ship\Parents\Actions\Action;

class FactDataNewAction extends Action
{
    public function run($folder)
    {
        echo "\nRunning FactDataNewAction for folder: [$folder]";
        return app(FactDataNewTask::class)->run($folder);
    }
}
