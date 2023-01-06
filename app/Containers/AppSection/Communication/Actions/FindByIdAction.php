<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Communication\Models\Communication;
use App\Containers\AppSection\Communication\Tasks\FindByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class FindByIdAction extends Action
{
    public function run(Request $request)
    {
        return app(FindByIdTask::class)->run($request->id);
    }
}
