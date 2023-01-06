<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Mapper\Profile;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileFieldTask;
use App\Containers\AppSection\UserProfile\Tasks\UpdateUserProfileTask;
use App\Containers\AppSection\UserProfile\Tasks\CreateUserProfileTask;
use App\Ship\Parents\Tasks\FindEntityByTableAndIdTask;
use App\Ship\Parents\Actions\SubAction;

class UpdateUserProfileSubAction extends SubAction
{
    public function run(string $group, string $key, $value, int $userId, string $borrower_type): bool
    {
        // TODO: continue or throw error
        if (!Profile::isValidField($group, $key, $borrower_type)) {
            return false;
        }

        $relationTable = Profile::getFieldRelation($group, $key);
        if ($relationTable) {
            if (is_array($value)) {

                if (!count($value))
                    return false;

                $newInput = [];
                foreach ($value as $id) {
                    if (!empty($id)) {
                        $entity = app(FindEntityByTableAndIdTask::class)->run($relationTable, $id);
                    } else {
                        $entity = null;
                    }

                    if ($entity != null) {
                        $newInput[] = $id;
                    }
                }
                $value = $newInput;
                if (count($value) == 0) {
                    return false;
                }
            } else {
                $entity = app(FindEntityByTableAndIdTask::class)->run($relationTable, $value);
                if ($entity == null) {
                    return false;
                }
            }
        }

        if (is_null($value)) {
            $value = "";
        }
        if (!is_string($value)) {
            $value = json_encode($value);
        }

        $userProfileValue = app(FindUserProfileFieldTask::class)->run($userId, $group, $key);
        if ($userProfileValue != null) {
            if ($userProfileValue == $value) {
                return true;
            }
            app(UpdateUserProfileTask::class)->run($userProfileValue->id, $value);
        } else {
            app(CreateUserProfileTask::class)->run($userId, $key, $group, $value);
        }

        return true;
    }
}
