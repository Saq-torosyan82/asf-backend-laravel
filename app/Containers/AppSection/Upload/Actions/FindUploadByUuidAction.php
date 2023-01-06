<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Models\Upload;
use App\Containers\AppSection\Upload\Tasks\FindUploadByUuidTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindUploadByUuidAction extends Action
{
    public function run(Request $request): Upload
    {
        return app(FindUploadByUuidTask::class)->run($request->uuid);
    }
}
