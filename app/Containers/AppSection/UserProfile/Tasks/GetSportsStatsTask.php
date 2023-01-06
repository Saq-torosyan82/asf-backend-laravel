<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Ship\Parents\Tasks\Task;

class GetSportsStatsTask extends Task
{
    protected DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function run($userId)
    {
        $res = $this->dealRepository->select('sport_id',\DB::raw('count(*) AS total'))->whereNotNull('sport_id')
            ->when(isset($userId), function($query) use($userId){
                return $query->where('user_id', $userId);
            })
            ->groupBy('sport_id')->with('sport')->get();
        $total = 0;
        $data = [];

        foreach ($res as $row) {
            $data[] = [
                'number' => $row->total,
                'label' => ucfirst(str_replace('_',' ',$row->sport->name))
            ];

            $total += $row->total;
        }
        return [
            'total' => $total,
            'data' => $data
        ];
    }
}
