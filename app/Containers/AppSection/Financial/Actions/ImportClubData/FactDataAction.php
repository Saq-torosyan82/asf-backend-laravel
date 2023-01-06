<?php

namespace App\Containers\AppSection\Financial\Actions\ImportClubData;

use App\Containers\AppSection\Financial\Tasks\ImportClubData\FactDataTask;
use App\Ship\Parents\Actions\Action;

class FactDataAction extends Action
{
    public function run($folder)/*: Facts*/
    {
        /*
        $data = $request->sanitizeInput([
            // add your request data here
        ]);
        */

        echo "\nRunning FactDataAction for folder: [$folder]";
        $error = '';
        return app(FactDataTask::class)->run($folder, $error);
    }
}
