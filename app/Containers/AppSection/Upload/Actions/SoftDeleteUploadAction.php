<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Tasks\SoftDeleteUploadTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class SoftDeleteUploadAction extends Action
{
    public function run(Request $request)
    {
        return app(SoftDeleteUploadTask::class)->run($request->id);
    }
}
