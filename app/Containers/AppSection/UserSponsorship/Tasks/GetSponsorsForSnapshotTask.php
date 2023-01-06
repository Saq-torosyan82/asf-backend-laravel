<?php

namespace App\Containers\AppSection\UserSponsorship\Tasks;

use App\Containers\AppSection\System\Tasks\GetClubSponsorsByIdsTask;
use App\Containers\AppSection\System\Tasks\GetSportBrandsByIdsTask;
use App\Containers\AppSection\System\Tasks\GetSportSponsorsByIdsTask;
use App\Containers\AppSection\UserSponsorship\Data\Repositories\UserSponsorshipRepository;
use App\Containers\AppSection\UserSponsorship\Enums\Key as UserSponsorshipKey;
use App\Ship\Parents\Tasks\Task;

class GetSponsorsForSnapshotTask extends Task
{
    protected UserSponsorshipRepository $repository;

    public function __construct(UserSponsorshipRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $user_id)
    {
        $userSponsorships = app(GetAllUserSponsorshipsTask::class)->addRequestCriteria()->orderByType()->run($user_id);
        $sponsorshipsByType = $userSponsorships->groupBy('type');
        $other = 'Other';
        $groupedList = [
           [
               'label' => ucfirst(UserSponsorshipKey::SHIRT_TYPE),
               'value' => [],
           ],
            [
                'label' => ucfirst(UserSponsorshipKey::KIT_TYPE),
                'value' => [],
            ],
            [
                'label' => ucfirst(UserSponsorshipKey::SLEEVE_TYPE),
                'value' => [],
            ],
            [
                'label' => $other,
                'value' => [],
            ]
        ];
        $key = array_search($other, array_column($groupedList, 'label'));
        if (isset($sponsorshipsByType[UserSponsorshipKey::BRAND_TYPE])) {
            $brandIds = $sponsorshipsByType[UserSponsorshipKey::BRAND_TYPE]->pluck('entity_id')->all();
            $res = app(GetSportBrandsByIdsTask::class)->addRequestCriteria()->run($brandIds);
            foreach ($res as $row) {
                $groupedList[$key]['value'][] = $row->name;
            }
            unset($sponsorshipsByType[UserSponsorshipKey::BRAND_TYPE]);
        }

        if (isset($sponsorshipsByType[UserSponsorshipKey::SPONSOR_TYPE])) {
            $sponsorIds = $sponsorshipsByType[UserSponsorshipKey::SPONSOR_TYPE]->pluck('entity_id')->all();
            $res = app(GetSportSponsorsByIdsTask::class)->addRequestCriteria()->run($sponsorIds);
            foreach ($res as $row) {
                $groupedList[$key]['value'][] = $row->name;
            }
            unset($sponsorshipsByType[UserSponsorshipKey::SPONSOR_TYPE]);
        }

        if (isset($sponsorshipsByType[UserSponsorshipKey::MAIN_PARTNER_TYPE])) {
            $sponsorIds = $sponsorshipsByType[UserSponsorshipKey::MAIN_PARTNER_TYPE]->pluck('entity_id')->all();
            $res = app(GetSportSponsorsByIdsTask::class)->addRequestCriteria()->run($sponsorIds);
            foreach ($res as $row) {
                $groupedList[$key]['value'][] = $row->name;
            }
            unset($sponsorshipsByType[UserSponsorshipKey::MAIN_PARTNER_TYPE]);
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
                $key = array_search(ucfirst($clubSponsorType[$row->id]), array_column($groupedList, 'label'));
                $groupedList[$key]['value'][] = $row->name;
            }
        }
        return $groupedList;
    }

}
