<?php

namespace App\Containers\AppSection\User\Actions;


use App\Containers\AppSection\User\Tasks\GetChildUsersByParentIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetChildUsersByParentIdAction extends Action
{
    public function run(Request $request)
    {
        $crtUser = $request->user();
        $usersIds = [];

        if ($crtUser->isAgency() && $crtUser->isAgent()) {
            $usersIds = $crtUser->childs()->pluck('id')->toArray();
            $usersIds[] = $crtUser->id;
        } elseif($crtUser->isAgent()) {
            $usersIds[] = $crtUser->id;
        } elseif ($crtUser->isAdmin() && $request->has('user_id')) {
            $usersIds[] = $request->user_id;
        } else {
            // throw exception
        }

        return app(GetChildUsersByParentIdTask::class)->run($usersIds);
    }
}
