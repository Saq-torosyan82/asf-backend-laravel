<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Communication\Tasks\GetMessagesTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GetMessagesAction extends Action
{
    public function run(Request $request)
    {
        return app(GetMessagesTask::class)->run($request->com_id, Auth::user()->id);
    }
}
