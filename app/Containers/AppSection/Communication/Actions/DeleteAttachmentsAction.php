<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Upload\Tasks\FindUploadByIdTask;
use App\Containers\AppSection\Upload\Tasks\ForceDeleteUploadTask;
use App\Containers\AppSection\Upload\Tasks\SoftDeleteUploadTask;
use App\Ship\Exceptions\BadRequestException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class DeleteAttachmentsAction extends Action
{
    public function run(Request $request)
    {
        app(ForceDeleteUploadTask::class)->run($request->id);
    }
}
