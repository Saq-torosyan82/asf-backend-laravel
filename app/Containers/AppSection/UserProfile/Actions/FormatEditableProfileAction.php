<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\System\Tasks\FindLenderCriteriaByIdTask;
use App\Containers\AppSection\Upload\Tasks\FindUploadByIdTask;
use App\Containers\AppSection\Upload\Tasks\GetUserAvatarUrlTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByKeyTask;
use App\Containers\AppSection\UserProfile\Tasks\FormatLenderDealCriteriaTask;
use App\Containers\AppSection\UserProfile\Mapper\Profile;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Apiato\Core\Traits\HashIdTrait;
use App\Ship\Parents\Tasks\FindEntityByTableAndIdTask;

class FormatEditableProfileAction extends Action
{
    use HashIdTrait;

    public function run($userProfiles, User $user)
    {
        $response = [];
        foreach ($userProfiles as $userProfile) {
            $group = $userProfile->group;
            if ($group === '') {
                continue;
            }

            if (!isset($response[$group]) || !is_array($response[$group])) {
                $response[$group] = [];
            }

            $tableName = Profile::getFieldRelation($group, $userProfile->key);
            $isFile = Profile::isFile($group, $userProfile->key);

            if (!$tableName && !$isFile) {
                $response[$group][$userProfile->key] = $userProfile->value;
                continue;
            }

            if ($isFile) {
                try {
                    $upload = app(FindUploadByIdTask::class)->run($userProfile->value);
                    if (!$upload) {
                        continue;
                    }
                } catch (\Exception $e) {
                    continue;
                }

                $response[$group][$userProfile->key] = downloadUrl($upload->uuid);
                continue;
            }


            $decodedValue = json_decode($userProfile->value);
            if (is_array($decodedValue)) {
                $response[$group][$userProfile->key] = [];
                foreach ($decodedValue as $value) {
                    if (is_int($value)) {
                        $response[$group][$userProfile->key][] = $this->encode($value);
                    }
                }
            } else {
                if (is_int($decodedValue)) {
                    $response[$group][$userProfile->key] = $this->encode($decodedValue);
                }
            }
        }

        if ($user->isLender()) {
            $response['deal_criteria'] = app(FormatLenderDealCriteriaTask::class)->run($user->id);

            // hack for lender_type
            if(isset($response[Group::ACCOUNT]) && isset($response[Group::ACCOUNT][Key::LENDER_TYPE]))
            {
                // get lender type
                $lcData = app(FindLenderCriteriaByIdTask::class)->run($response[Group::ACCOUNT][Key::LENDER_TYPE]);
                if(is_null($lcData))
                {
                    $response[Group::ACCOUNT][Key::LENDER_TYPE] = '';
                }
                else {
                    $response[Group::ACCOUNT][Key::LENDER_TYPE] = $lcData->value;
                }
            }

            // get profile value for country address
            $country = app(FindUserProfileByKeyTask::class)->run($user->id, Group::COMPANY, Key::COUNTRY);
            // get country relation
            $relation = 'countries';
            $entity = app(FindEntityByTableAndIdTask::class)->run($relation, $country->value);
            $response[Group::COMPANY]['country_txt'] = $entity->name;
        }
        elseif ($user->isAthlete() || $user->isCorporate())
        {
            // SEEMEk: not the best option but it is ok for the moment

            // get profile value for sport
            $sport = app(FindUserProfileByKeyTask::class)->run($user->id, Group::PROFESSIONAL, Key::SPORT);
            // get sport relation
            $relation = Profile::getFieldRelation(Group::PROFESSIONAL, Key::SPORT);
            $entity = app(FindEntityByTableAndIdTask::class)->run($relation, $sport->value);
            $response[Group::PROFESSIONAL]['sport_txt'] = $entity->name;

            if($user->isCorporate())
            {
                // get profile value for country
                $country = app(FindUserProfileByKeyTask::class)->run($user->id, Group::PROFESSIONAL, Key::COUNTRY);
                if(!is_null($country)){
                    $relation = Profile::getFieldRelation(Group::PROFESSIONAL, Key::COUNTRY);
                    $entity = app(FindEntityByTableAndIdTask::class)->run($relation, $country->value);
                    $response[Group::PROFESSIONAL]['country_txt'] = $entity->name;
                }
            }
            elseif($user->isAthleteWithAgent())
            {
                // check for agent
                if(!isset($response['professional']) || !isset($response['professional']['agent_avatar']) ||
                    !isset($response['professional']['agent_name']) || !$response['professional']['agent_avatar'] ||
                    !$response['professional']['agent_name']) {
                    // get parent id
                    $parent = app(FindUserByIdTask::class)->run($user->parent_id);
                    // SEEMEk: this shouldn't be empty

                    // set agent name
                    if(!isset($response['professional']['agent_name']) || !$response['professional']['agent_name']) {
                        $response['professional']['agent_name'] = $parent->first_name . ' ' . $parent->last_name;
                    }

                    // set avatar
                    if(!isset($response['professional']['agent_avatar']) || !$response['professional']['agent_avatar']) {
                        $response['professional']['agent_avatar'] = app(GetUserAvatarUrlTask::class)->run($parent->id);
                    }
                }
            }
        }

        // add  user info
        $crt_user = \Auth::user();
        if ($crt_user->id != $user->id) {
            $response['user']['email'] = $user->email;
            $response['user']['first_name'] = $user->first_name;
            $response['user']['last_name'] = $user->last_name;
            $response['account']['user_type'] = is_null($user->roles->first()) ? '' : $user->roles->first()->name;
        }

        if(!isset($response['user'])){

            $response['user'] = [];
        }

        return $response;
    }
}
