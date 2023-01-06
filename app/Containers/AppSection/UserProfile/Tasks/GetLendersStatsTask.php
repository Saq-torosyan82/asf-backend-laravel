<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\System\Enums\LenderCriteriaType;
use App\Containers\AppSection\System\Data\Repositories\LenderCriteriaRepository;
use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Ship\Parents\Tasks\Task;

class GetLendersStatsTask extends Task
{
    protected LenderCriteriaRepository $criteriaRepository;
    protected UserProfileRepository $userProfileRepository;


    public function __construct(
        LenderCriteriaRepository $criteriaRepository,
        UserProfileRepository $userProfileRepository
    ) {
        $this->criteriaRepository = $criteriaRepository;
        $this->userProfileRepository = $userProfileRepository;
    }

    public function run($userId)
    {
        // get all lender type
        $res = $this->criteriaRepository->where('type', LenderCriteriaType::LENDER_TYPE)->get();
        $allTypes = [];
        foreach ($res as $row) {
            $allTypes[$row->id] = $row->value;
        }

        // get status
        $res = $this->userProfileRepository->select('value', \DB::raw('count(*) AS total'))
            ->where('group', Group::ACCOUNT)
            ->where('key', Key::LENDER_TYPE)
            ->when(isset($userId), function($query) use($userId){
                return $query->where('user_id', $userId);
            })
            ->groupBy('value')
            ->get();

        $total = 0;
        $data = [];
        foreach ($res as $row) {
            if (!isset($allTypes[$row->value])) {
                continue;
            } // this shouldn't happen

            $data[] = [
                'label' => $allTypes[$row->value],
                'number' => $row->total
            ];
            $total += $row->total;
        }

        return [
            'total' => $total,
            'data' => $data
        ];
    }
}
