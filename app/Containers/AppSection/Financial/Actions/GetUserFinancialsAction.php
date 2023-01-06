<?php

namespace App\Containers\AppSection\Financial\Actions;

use App\Containers\AppSection\Financial\Tasks\GetUserFinancialsDataTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GetUserFinancialsAction extends Action
{
    public function run(Request $request)
    {
        $user = Auth::user();
        return app(GetUserFinancialsDataTask::class)->addRequestCriteria()
            ->run($user->isCorporate() ? $user->id : null, $user->isAdmin() ? $request->club_id : null, null, $request->selected_currency ? : null);
    }
}
