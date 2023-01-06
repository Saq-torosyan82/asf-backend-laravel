<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Models\Upload;
use App\Containers\AppSection\Upload\Tasks\FindUploadByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindUploadByIdAction extends Action
{
    public function run(Request $request): Upload
    {
        return app(FindUploadByIdTask::class)->run($request->id);
    }
}
