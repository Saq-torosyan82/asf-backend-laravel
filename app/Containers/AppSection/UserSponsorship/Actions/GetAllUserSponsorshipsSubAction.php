<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Containers\AppSection\System\Tasks\GetClubSponsorsByIdsTask;
use App\Containers\AppSection\System\Tasks\GetSportBrandsByIdsTask;
use App\Containers\AppSection\System\Tasks\GetSportSponsorsByIdsTask;
use App\Containers\AppSection\UserSponsorship\Enums\Key;
use App\Containers\AppSection\UserSponsorship\Tasks\GetAllUserSponsorshipsTask;
use App\Ship\Parents\Actions\SubAction;
use Exception;

class GetAllUserSponsorshipsSubAction extends SubAction
{
    public function run(int $userId)
    {
        try {
            $userSponsorships = app(GetAllUserSponsorshipsTask::class)->addRequestCriteria()->orderByType()->run($userId);
            if ($userSponsorships == null || count($userSponsorships) == 0) {
                return [];
            }

            $sponsorshipsByType = $userSponsorships->groupBy('type');
            $nameList = [];
            if (isset($sponsorshipsByType[Key::BRAND_TYPE])) {
                $brandIds = $sponsorshipsByType[Key::BRAND_TYPE]->pluck('entity_id')->all();
                $res = app(GetSportBrandsByIdsTask::class)->addRequestCriteria()->run($brandIds);
                foreach ($res as $row) {
                    $nameList[Key::BRAND_TYPE][$row->id] = [
                        'name' => $row->name,
                        'logo' => $row->logo,
                    ];
                }
                unset($sponsorshipsByType[Key::BRAND_TYPE]);
            }
            if (isset($sponsorshipsByType[Key::SPONSOR_TYPE])) {
                $sponsorIds = $sponsorshipsByType[Key::SPONSOR_TYPE]->pluck('entity_id')->all();
                $res = app(GetSportSponsorsByIdsTask::class)->addRequestCriteria()->run($sponsorIds);
                foreach ($res as $row) {
                    $nameList[Key::SPONSOR_TYPE][$row->id] = [
                        'name' => $row->name,
                        'logo' => $row->logo
                    ];
                }
                unset($sponsorshipsByType[Key::SPONSOR_TYPE]);
            }

            $clubSponsorType = [];
            if (count($sponsorshipsByType)) {
                $clubSponsorIds = [];
                foreach ($sponsorshipsByType as $type => $tData) {
                    foreach ($tData as $row) {
                        $clubSponsorIds[] = $row->entity_id;
                        $clubSponsorType[$row->entity_id] = $type;
                    }
                }

                $res = app(GetClubSponsorsByIdsTask::class)->run($clubSponsorIds);
                foreach ($res as $row) {
                    $nameList[$clubSponsorType[$row->id]][$row->id] = [
                        'name' => $row->name,
                        'logo' => $row->logo
                    ];
                }
            }

            $result = [];
            foreach ($userSponsorships as $sponsorship) {
                $newSponsorship = [];
                $name = '';
                $logo = '';
                if (isset($nameList[$sponsorship->type]) && isset($nameList[$sponsorship->type][$sponsorship->entity_id])) {
                    $name = $nameList[$sponsorship->type][$sponsorship->entity_id]['name'];
                    $logo = $this->getLogo($sponsorship->type, $nameList[$sponsorship->type][$sponsorship->entity_id]['logo']);
                }

                $newSponsorship['id'] = $sponsorship->getHashedKey();
                $newSponsorship['type'] = $sponsorship->type;
                $newSponsorship['start_date'] = $sponsorship->start_date;
                $newSponsorship['end_date'] = $sponsorship->end_date;
                $newSponsorship['logo'] = $logo;
                $newSponsorship['name'] = $name;

                $result[] = $newSponsorship;
            }

            return $result;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    private function getLogo($type, $logo)
    {
        $map = [
            Key::BRAND_TYPE => LogoAssetType::SPORT_BRAND,
            Key::SPONSOR_TYPE => LogoAssetType::SPORT_SPONSOR,
            Key::SHIRT_TYPE => LogoAssetType::CLUB_SPONSOR,
            Key::SLEEVE_TYPE => LogoAssetType::CLUB_SPONSOR,
            Key::KIT_TYPE => LogoAssetType::CLUB_SPONSOR,
            Key::MAIN_PARTNER_TYPE => LogoAssetType::CLUB_SPONSOR
        ];

        if (!isset($map[$type]) || !$logo) {
            return LogoAssetType::getDetaultLogo(LogoAssetType::SPONSOR_DEFAULT);
        }

        return route(
            'web_system_logo_asset',
            [LogoAssetType::getLogoPath($map[$type]), $logo]
        );
    }
}
