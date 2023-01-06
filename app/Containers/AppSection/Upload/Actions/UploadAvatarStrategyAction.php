<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UploadAvatarStrategyAction extends Action
{
    public function run(Request $request, $user_id = null, $user_type = null)
    {
        if($request->file('agent_avatar')) {
            $uuid = app(UploadAgentAvatarAction::class)->run($request, $user_id, $user_type);
        }else {
            $uuid = app(UploadAvatarAction::class)->run($request, $user_id, $user_type);
        }

        return $uuid;
    }
}
