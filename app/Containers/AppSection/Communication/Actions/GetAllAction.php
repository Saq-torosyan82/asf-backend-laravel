<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Communication\Tasks\GetAllTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GetAllAction extends Action
{
    public function run(Request $request)
    {
        return app(GetAllTask::class)->run(Auth::user()->id);
    }
}
