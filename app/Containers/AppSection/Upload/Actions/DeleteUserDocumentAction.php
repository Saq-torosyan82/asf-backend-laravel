<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Tasks\DeleteUserDocumentTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeleteUserDocumentAction extends Action
{
    public function run(Request $request)
    {
        return app(DeleteUserDocumentTask::class)->run($request->uuid);
    }
}
