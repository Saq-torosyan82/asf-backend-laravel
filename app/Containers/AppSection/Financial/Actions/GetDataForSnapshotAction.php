<?php

namespace App\Containers\AppSection\Financial\Actions;

use App\Containers\AppSection\Financial\Tasks\GetDataForSnapshotTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GetDataForSnapshotAction extends Action
{
    public function run(Request $request)
    {
        $user = Auth::user();
        if (isset($request->club_id)) {
            return app(GetDataForSnapshotTask::class)
                ->run($request->club_id, null, $request->selected_currency ? : null);
        } elseif ($user->isCorporate()) {
            return app(GetDataForSnapshotTask::class)
                ->run(null,$user->id, $request->selected_currency ? : null);
        } else {
            throw new \Exception("You don't have permission");
        }

    }
}
