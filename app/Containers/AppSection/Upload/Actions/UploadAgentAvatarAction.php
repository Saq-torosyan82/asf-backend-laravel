<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Tasks\ForceDeleteUploadTask;
use App\Containers\AppSection\UserProfile\Actions\UpdateUserProfileSubAction;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileFieldTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Ship\Parents\Exceptions\Exception\NotFoundException;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Actions\Action;

class UploadAgentAvatarAction extends Action
{
    public function run(Request $request, $user_id = null, $user_type = null)
    {
        if (is_null($user_id)) {
            $user_id = $request->user_id == null ? $request->user()->id : $request->user_id;
        }

        // SEEMEk: check the permissions !!!
        if (is_null($user_type)) {
            $user_type = app(GetBorrowerTypeTask::class)->run($user_id);
        }

        $existingAvatar = app(FindUserProfileFieldTask::class)->run($user_id, Group::PROFESSIONAL, Key::AGENT_AVATAR);
        if ($existingAvatar != null) {
            app(ForceDeleteUploadTask::class)->run($existingAvatar->value);
        }

        $upload = app(UploadFileSubAction::class)->run($request->file('agent_avatar'), UploadType::AGENT_AVATAR, $user_id);

        app(UpdateUserProfileSubAction::class)->run(Group::PROFESSIONAL, Key::AGENT_AVATAR, $upload->id, $user_id, $user_type);

        return $upload->uuid;
    }
}
