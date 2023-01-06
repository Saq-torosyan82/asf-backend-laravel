<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Communication\Models\Communication;
use App\Containers\AppSection\Communication\Tasks\UpdateTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdateAction extends Action
{
    public function run(Request $request): Communication
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(UpdateTask::class)->run($request->id, $data);
    }
}
