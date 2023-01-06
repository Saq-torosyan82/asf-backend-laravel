<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Upload\Actions\UploadAvatarAction;
use App\Containers\AppSection\UserProfile\Mapper\Profile;
use App\Containers\AppSection\UserProfile\Tasks\CreateUserProfileTask;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AddAthleteRequest;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Ship\Parents\Actions\Action;

class AddAthleteAction extends Action
{
    public function run(AddAthleteRequest $request)
    {
        $userProfileInput = $request->all();

        // crete user
        $userInput = $request->sanitizeInput(
            [
                'account.first_name',
                'account.last_name',
                'account.email'
            ]
        );

        // small hack for the moment
        if(isset($userProfileInput['professional']))
        {
            foreach(array('club', 'country', 'league') as $key){
                if(isset($userProfileInput['professional'][$key]) && is_array($userProfileInput['professional'][$key])){
                    unset($userProfileInput['professional'][$key]);
                }
            }

        }

        $user = app(CreateUserByCredentialsTask::class)->run(
            false,
            $userInput['account']['email'],
            '',
            $userInput['account']['first_name'],
            $userInput['account']['last_name'],
            null,
            null,
            true,
            $request->user()->id
        );
        $user->assignRole(app(FindRoleTask::class)->run(PermissionType::BORROWER));

        // add borrower type
        app(CreateUserProfileTask::class)->run(
            $user->id,
            Key::BORROWER_TYPE,
            Group::ACCOUNT,
            BorrowerType::ATHLETE,
            PermissionType::BORROWER
        );

        // add borrower mode id
        app(CreateUserProfileTask::class)->run(
            $user->id,
            Key::BORROWER_MODE_ID,
            Group::ACCOUNT,
            BorrowerType::getId(BorrowerType::PROFESSIONAL_ATHLETE),
            PermissionType::BORROWER
        );

        // add data to profile
        foreach ($userProfileInput as $group => $value) {
            if (!is_array($value) || $group == Group::ACCOUNT) {
                continue;
            }
            foreach ($value as $key => $value2) {
                if (!Profile::isValidField($group, $key, BorrowerType::ATHLETE)) {
                    continue;
                } // maybe should return an error or logging

                app(CreateUserProfileTask::class)->run(
                    $user->id,
                    $key,
                    $group,
                    $value2,
                    BorrowerType::ATHLETE
                );
            }
        }

        // add avatar
        if ($request->has('avatar') && $request->file('avatar')) {
            $uploadId = app(UploadAvatarAction::class)->run($request, $user->id, BorrowerType::ATHLETE);
        }

        return ['id' => $user->getHashedKey()];
    }
}
