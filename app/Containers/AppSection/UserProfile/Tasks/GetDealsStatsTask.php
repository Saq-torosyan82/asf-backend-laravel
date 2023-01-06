<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Ship\Parents\Tasks\Task;

class GetDealsStatsTask extends Task
{
    protected DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository) {
        $this->dealRepository = $dealRepository;
    }

    public function run($userId)
    {
        $res = $this->dealRepository->select('contract_type', \DB::raw('count(*) AS total'))
            ->when(isset($userId), function($query) use($userId){
                return $query->where('user_id', $userId);
            })
            ->groupBy('contract_type')
            ->get();
        $total = 0;
        $data = [];

        foreach ($res as $row) {
            $data[] = [
                'number' => $row->total,
                'label' => ucfirst(str_replace('_', ' ', $row->contract_type))
            ];

            $total += $row->total;
        }

        return [
            'total' => $total,
            'data' => $data
        ];
    }
}
