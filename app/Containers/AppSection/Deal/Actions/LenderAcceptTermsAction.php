<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Tasks\CreateLenderTermTask;
use App\Containers\AppSection\Deal\Tasks\FindDealLenderTermByDealAndUserIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class LenderAcceptTermsAction extends Action
{
    public function run(Request $request)
    {
        $userId = $request->user()->id;
        $dealId = $request->deal_id;

        $term = app(FindDealLenderTermByDealAndUserIdTask::class)->run($dealId, $userId);

        if($term == null)
            app(CreateLenderTermTask::class)->run([
                'user_id' => $userId,
                'deal_id' => $dealId
            ]);
    }
}
