<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\Upload\Actions\UploadAgentAvatarAction;
use App\Containers\AppSection\Upload\Actions\UploadAvatarAction;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Mapper\Profile;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByUserIdTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdateUserProfileAction extends Action
{
    public function run(Request $request, $update_me = true)
    {
        $userProfileInput = $request->all();

        if ($update_me) {
            $user = $request->user();
            $userId = $user->id;
        } else {
            $userId = $userProfileInput['id'];
            // get user
            $user = app(FindUserByIdTask::class)->run($userId);
        }

        $userType = '';
        if ($user->isBorrower()) {
            $userType = app(GetBorrowerTypeTask::class)->run($userId);
        } elseif ($user->isLender()) {
            $userType = PermissionType::LENDER;
        }

        // get user/borrower type
        // SEEMEk: not ok because user can be lender or admin !!!

        foreach ($userProfileInput as $group => $inputKeys) {
            // skip account group
            if (($group == Group::ACCOUNT) || ($group == 'deal_criteria')) {
                continue;
            }

            // SEEMEk: should add method for skip specific keys ??
            if (!is_array($inputKeys)) {
                continue;
            }

            foreach ($inputKeys as $key => $input) {
                // skip if file
                if (Profile::isFile($group, $key)) {
                    continue;
                }
                app(UpdateUserProfileSubAction::class)->run($group, $key, $input, $userId, $userType);
            }
        }

        if ($request->has('avatar') && $request->file('avatar')) {
            try {
                $user_avatar_id = null;
                if (!$update_me) {
                    $user_avatar_id = $userId;
                }
                $uploadId = app(UploadAvatarAction::class)->run($request, $user_avatar_id, $userType);
            } catch (\Exception $e) {
                throw $e;
            }
        }

        if ($request->has('agent_avatar') && $request->file('agent_avatar')) {
            try {
                $uploadId = app(UploadAgentAvatarAction::class)->run($request, $userId, $userType);
            } catch (\Exception $e) {
                throw $e;
            }
        }

        // send notification
        if ($user->isBorrower()) {
            $data = [
                // maybe add more data
                'vars' => [
                    'email' => $user->email,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'linkToProfile' => config('appSection-authentication.login_token_redirect') . '/edit',
                ],
                'allow_multiple' => true,
            ];

            try {
                app(NotificationTask::class)->run($user, MailContext::CHANGED_USER_PROFILE, $data);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }

        return app(FindUserProfileByUserIdTask::class)->run($userId);
    }
}
