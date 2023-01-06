<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\Deal\Tasks\GetDealsByUserIdTask;
use App\Containers\AppSection\Financial\Enums\FactSectionsName;
use App\Containers\AppSection\Financial\Tasks\GetFactsByClubAndNameIdsTask;
use App\Containers\AppSection\Payment\Tasks\GetAllReceivedPaymentsTask;
use App\Containers\AppSection\Payment\Tasks\GetPaymentsForBorrowerTask;
use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Containers\AppSection\System\Tasks\FindSportClubByIdTask;
use App\Containers\AppSection\System\Tasks\FindSportClubTask;
use App\Containers\AppSection\System\Tasks\FindSportLeagueTask;
use App\Containers\AppSection\System\Tasks\GetSportLeagueByIdTask;
use App\Containers\AppSection\Upload\Tasks\FindUploadByIdTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Mapper\Profile;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByKeyTask;
use App\Containers\AppSection\UserProfile\Tasks\FormatLenderDealCriteriaTask;
use App\Containers\AppSection\UserProfile\Tasks\FormatReadableLenderDealCriteriaTask;
use App\Containers\AppSection\UserProfile\Tasks\GetAuthenticatedUserTypeTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowersStatsTask;
use App\Containers\AppSection\UserProfile\Tasks\GetCountriesStatsTask;
use App\Containers\AppSection\UserProfile\Tasks\GetDealsStatsTask;
use App\Containers\AppSection\UserProfile\Tasks\GetLendersStatsTask;
use App\Containers\AppSection\UserProfile\Tasks\GetMoneyStatsTask;
use App\Containers\AppSection\UserProfile\Tasks\GetSportsStatsTask;
use App\Ship\Parents\Actions\Action;
use Apiato\Core\Traits\HashIdTrait;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\FindEntityByTableAndIdTask;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class FormatReadableProfileAction extends Action
{
    use HashIdTrait;

    public function run($userProfiles)
    {
        $response = [];
        // get user type
        $userType = '';
        $user = Auth::user();
        try {
            $userType = app(GetAuthenticatedUserTypeTask::class)->run($user);
        } catch (Exception $e) {
            // silently ignore
        }

        $socialMediaFollowers = [];
        foreach ($userProfiles as $userProfile) {
            $group = $userProfile->group;
            if ($group === '') {
                continue;
            }

            if (!isset($response[$group]) || !is_array($response[$group])) {
                $response[$group] = [];
            }


            if ($group == Group::SOCIAL_MEDIA) {
                if (!count($socialMediaFollowers)) {
                    foreach ($userProfile->user->socialMediaFollowers as $item) {
                        $socialMediaFollowers[$item->type] = $this->getSocialMedia($item);
                    }
                }

                if ($userProfile->value) {
                    $response[$group][$userProfile->key] = $this->getSocialMedia(null);
                    $response[$group][$userProfile->key]['link'] = $userProfile->value;
                    if (isset($socialMediaFollowers[$userProfile->key])) {
                        $response[$group][$userProfile->key] = $socialMediaFollowers[$userProfile->key];
                    }
                }
                continue;
            }

            if ($this->useProfileValue($group, $userProfile->key, $userType)) {
                $response[$group][$userProfile->key] = $userProfile->value;
                continue;
            }

            $tableName = Profile::getFieldRelation($group, $userProfile->key);
            $isFile = Profile::isFile($group, $userProfile->key);
            $config = Profile::getFieldConfig($group, $userProfile->key, $userType);

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
                    $entity = app(FindEntityByTableAndIdTask::class)->run($tableName, $value);
                    if ($entity != null) {
                        if ($group == Group::PROFESSIONAL && $userProfile->key == Key::PREVIOUS_CLUBS) {
                            $response[$group][$userProfile->key][] = [
                                'id' => $this->encode($entity->id),
                                'name' => $entity->name,
                                'logo' => $this->getLogo(LogoAssetType::SPORT_CLUB, $entity->logo)
                            ];
                        } else {
                            $response[$group][$userProfile->key][] = $entity->name;
                        }
                    }
                }
            } else {
                if (is_int($decodedValue)) {
                    $entity = app(FindEntityByTableAndIdTask::class)->run($tableName, $decodedValue);
                    if (!empty($entity)) {
                        $response[$group][$userProfile->key] = $entity->name;

                        if (isset($config['addt_fields']) && is_array($config['addt_fields']) && count($config['addt_fields'])) {
                            foreach ($config['addt_fields'] as $key => $field) {
                                $response[$group][$field] = $entity->{$key};
                            }
                        }
                    }
                }
            }

            if (isset($config['dashboard_has_id']) && $config['dashboard_has_id']) {
                $response[$group][$userProfile->key . '_' . 'id'] = $this->encode($userProfile->value);
            }
        }// foreach

        // small hack for file
        if (!isset($response[Group::USER]) || !isset($response[Group::USER][Key::AVATAR])) {
            $response[Group::USER][Key::AVATAR] = '';
        }

        if ($user->isCorporate()) {
            $this->setClubData($response);
            $this->setLeagueData($response);
            if (!$response[Group::USER][Key::AVATAR] && isset($response[Group::PROFESSIONAL]) &&
                isset($response[Group::PROFESSIONAL]['club_id'])) {
                // get logo from clubs
                $club_id = $this->decode($response[Group::PROFESSIONAL]['club_id']);
                $club = app(FindSportClubByIdTask::class)->run($club_id);
                if ($club->logo) {
                    $response[Group::USER][Key::AVATAR] = $this->getLogo(LogoAssetType::SPORT_CLUB, $club->logo);
                    $response[Group::USER]['is_public_avatar'] = 1;
                }
            }
        } elseif ($user->isAthlete()) {
            $this->setAthleteData($response);
        }

        // add dashboard info
        $userId = !$user->hasAdminRole() ? $user->id : null;

        $response['stats']['lenders'] = app(GetLendersStatsTask::class)->run($userId);
        $response['stats']['borrowers'] = app(GetBorrowersStatsTask::class)->run($userId);
        $response['stats']['deals'] = app(GetDealsStatsTask::class)->run($userId);
        $response['stats']['sport'] = app(GetSportsStatsTask::class)->run($userId);
        $response['stats']['country'] = app(GetCountriesStatsTask::class)->run($userId);

        if ($user->isLender()) {
            $response['deal_criteria'] = app(FormatReadableLenderDealCriteriaTask::class)->run(Auth::user()->id);
        }
        if ($user->isBorrower()) {
            $response['stats']['payments'] = app(GetPaymentsForBorrowerTask::class)->run(Auth::user()->id);
        } else {
            $response['stats']['received_money'] = app(GetAllReceivedPaymentsTask::class)->run($userId, $user->isLender());
        }
        $response['stats']['money'] = app(GetMoneyStatsTask::class)->run($userId, $user->isLender());
        $response['account']['isAgency'] = $user->isAgency();

        // add social media last update
        if (isset($response['social_media']) && is_array($response['social_media']) && count($response['social_media'])) {
            $max = '';
            foreach ($response['social_media'] as $row) {
                if (strcmp($max, $row['last_checked']))
                    $max = $row['last_checked'];
            }
            $response['social_media']['last_update'] = $max;
        }

        return $response;
    }

    private function useProfileValue($group, $key, $userType)
    {
        $tableName = Profile::getFieldRelation($group, $key);
        $isFile = Profile::isFile($group, $key);
        $config = Profile::getFieldConfig($group, $key, $userType);

        if (!$tableName && !$isFile && ($group !== Group::SOCIAL_MEDIA)) {
            return true;
        }

        if ($tableName && isset($config['dashboard_skip_relation']) && $config['dashboard_skip_relation'])
            return true;

        return false;
    }

    protected function getSocialMedia($socialMedia)
    {
        if ($socialMedia) {
            return [
                'link' => $socialMedia->link,
                'nb_followers' => $socialMedia->nb_followers,
                'last_checked' => $socialMedia->last_checked
            ];
        }
        return [
            'link' => '',
            'nb_followers' => 0,
            'last_checked' => null
        ];
    }

    /**
     * @param $response
     * @return false|void
     * @throws \App\Ship\Exceptions\NotFoundException
     */
    private function setLeagueData(&$response)
    {
        // get league info
        if (!isset($response[Group::PROFESSIONAL]['club_id']) || !isset($response[Group::PROFESSIONAL]['league_id'])) {
            return false;
        }

        $league_id = $this->decode($response[Group::PROFESSIONAL]['league_id']);

        $league = app(GetSportLeagueByIdTask::class)->run($league_id);
        if (is_null($league)) {
            return false;
        }

        // add league name
        $response[Group::PROFESSIONAL]['league_name'] = $league->name;
        // add logo
        $response[Group::PROFESSIONAL]['league_logo'] = $this->getLogo(LogoAssetType::SPORT_LEAGUE, $league->logo);
        // add association name
        $response[Group::PROFESSIONAL]['association_name'] = $league->association_name;
        // add association logo
        $response[Group::PROFESSIONAL]['association_logo'] = $this->getLogo(LogoAssetType::SPORT_ASSOCIATION, $league->association_logo);
        // add confederation name
        $response[Group::PROFESSIONAL]['confederation_name'] = $league->confederation_name;
        // add confederation logo
        $response[Group::PROFESSIONAL]['confederation_logo'] = $this->getLogo(LogoAssetType::SPORT_CONFEDERATION, $league->confederation_logo);
    }

    /**
     * @param $response
     * @return void
     */
    private function setClubData(&$response)
    {
        $user = Auth::user();
        // get club id
        $clubProfile = app(FindUserProfileByKeyTask::class)->run($user->id, Group::PROFESSIONAL, Key::CLUB);
        if (is_null($clubProfile)) {
            return false;
        }

        // get fact data
        $data = app(GetFactsByClubAndNameIdsTask::class)->run($clubProfile->value, [
            FactSectionsName::getId(FactSectionsName::FOUNDED),
            FactSectionsName::getId(FactSectionsName::MANAGER),
            FactSectionsName::getId(FactSectionsName::OWNER_S)
        ]);

        $map = [
            FactSectionsName::FOUNDED => 'club_founded',
            FactSectionsName::MANAGER => 'club_manager',
            FactSectionsName::OWNER_S => 'club_owners',
        ];

        // add empty values (for the moment)
        foreach ($map as $k => $v) {
            $response[Group::COMPANY][$v] = 'n/a';
        }

        // data
        foreach ($data as $row) {
            $key = FactSectionsName::getNameById($row->fact_name_id);
            if (is_null($key) || !isset($map[$key])) {
                continue;
            }
            $response[Group::COMPANY][$map[$key]] = $row->value;
        }
    }

    private function setAthleteData(&$response)
    {
        if (!isset($response['professional']['club_id'])) {
            return false;
        }

        $logo = '';
        $club_id = $this->decode($response['professional']['club_id']);
        // get club
        $club = app(FindSportClubByIdTask::class)->run($club_id);
        if ($club->logo) {
            $logo = $this->getLogo(LogoAssetType::SPORT_CLUB, $club->logo);
        }

        $response['professional']['club_logo'] = $logo;
    }

    /**
     * @param $type
     * @param $logo
     * @return string
     */
    private function getLogo($type, $logo)
    {
        if ($logo) {
            return route(
                'web_system_logo_asset',
                [LogoAssetType::getLogoPath($type), $logo]
            );
        }

        return LogoAssetType::getDetaultLogo($type);
    }


}
