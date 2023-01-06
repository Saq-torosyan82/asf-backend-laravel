<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\System\Data\Repositories\BorrowerTypeRepository;
use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Ship\Parents\Tasks\Task;

class GetBorrowersStatsTask extends Task
{
    protected BorrowerTypeRepository $borrowerTypeRepository;
    protected UserProfileRepository $userProfileRepository;


    public function __construct(
        BorrowerTypeRepository $borrowerTypeRepository,
        UserProfileRepository $userProfileRepository
    ) {
        $this->borrowerTypeRepository = $borrowerTypeRepository;
        $this->userProfileRepository = $userProfileRepository;
    }

    public function run($userId)
    {
        // get all lender types
        $res = $this->borrowerTypeRepository->get();
        $borrowers = [];
        foreach ($res as $row) {
            $borrowers[$row->id] = $row->name;
        }

        // get borrowers
        $res = $this->userProfileRepository->select('value', \DB::raw('count(*) AS total'))
            ->where('group', Group::ACCOUNT)
            ->where('key', Key::BORROWER_MODE_ID)
            ->when(isset($userId), function($query) use($userId){
                return $query->where('user_id', $userId);
            })
            ->groupBy('value')
            ->get();

        $total = 0;
        $data = [];
        foreach ($res as $row) {
            if (!isset($borrowers[$row->value])) {
                continue;
            } // this shouldn't happen

            $data[] = [
                'label' => $borrowers[$row->value],
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
