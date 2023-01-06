<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Communication\Tasks\GetParticipantsForDealTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GetParticipantsForDealAction extends Action
{
    public function run(Request $request)
    {
        return app(GetParticipantsForDealTask::class)->addRequestCriteria()->run($request->deal_id ? : null, Auth::user()->id);
    }
}
