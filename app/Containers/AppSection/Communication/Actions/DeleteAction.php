<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Communication\Tasks\DeleteTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeleteAction extends Action
{
    public function run(Request $request)
    {
        return app(DeleteTask::class)->run($request->id);
    }
}
