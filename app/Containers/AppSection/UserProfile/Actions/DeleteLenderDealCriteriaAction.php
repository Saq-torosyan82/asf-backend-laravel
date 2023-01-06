<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Tasks\DeleteLenderDealCriteriaTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeleteLenderDealCriteriaAction extends Action
{
    public function run(Request $request)
    {
        return app(DeleteLenderDealCriteriaTask::class)->run($request->lender_deal_criteria_id);
    }
}
