<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Containers\AppSection\System\Tasks\GetCountryByIdTask;
use App\Ship\Parents\Tasks\Task;

class GetCountriesStatsTask extends Task
{
    protected DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function run($userId)
    {
        {
            $res = $this->dealRepository->select('country_id', \DB::raw('count(*) AS total'))
                ->whereNotNull('country_id')
                ->when(isset($userId), function($query) use($userId){
                    return $query->where('user_id', $userId);
                })
                ->groupBy('country_id')
                ->get();
            $data = [];
            foreach ($res as $row) {
                $country = app(GetCountryByIdTask::class)->run($row->country_id);
                $data[] = [
                    'label' => ucfirst($country->name),
                    'number' => $row->total,
                    'key' => $country->code ?? ''
                ];
            }
            return ['data' => $data];
        }
    }
}
