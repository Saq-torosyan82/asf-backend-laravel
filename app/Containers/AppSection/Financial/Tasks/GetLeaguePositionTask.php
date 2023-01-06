<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FactIntervalRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FactNameRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FactValueRepository;
use App\Ship\Parents\Tasks\Task;

class GetLeaguePositionTask extends Task
{
    protected FactValueRepository $repository;
    protected FactNameRepository $factNameRepository;
    protected FactIntervalRepository $factIntervalRepository;

    public function __construct(FactValueRepository $repository,
                                FactIntervalRepository $factIntervalRepository,
                                FactNameRepository $factNameRepository)
    {
        $this->repository = $repository;
        $this->factNameRepository = $factNameRepository;
        $this->factIntervalRepository = $factIntervalRepository;
    }

    public function run($club_id, $limit)
    {
        $positions = [];
        $league = '';
        $factNames = $this->factNameRepository->select('id')->where('name', config('appSection-financial.league_label'))
            ->where('factsection_id', '<>',null)
            ->get()->toArray();
        $intervals = $this->factIntervalRepository->select('id','interval','index')
            ->orderBy('index', 'DESC')
            ->limit($limit)
            ->get()->toArray();

        if($factNames != null) {
            foreach ($factNames as $factName) {
                foreach ($intervals as $interval) {
                    $position = "";
                    $itemPosition = $this->repository->select('value', 'fact_interval_id')
                        ->where('fact_interval_id',$interval['id'])
                        ->where('fact_name_id', $factName['id'])
                        ->where('club_id', $club_id)
                        ->first();
                    if (isset($itemPosition) && $itemPosition !== null) {
                        if (strpos( $itemPosition->value, '(')) {
                            $value = explode('(',$itemPosition->value);
                            $position = $this->getPosition(trim($value[0]));
                            $league = rtrim(trim($value[1]), ')');
                        } else {
                            $position = $this->getPosition($itemPosition->value);
                        }
                    }
                    $positions[explode('/', $interval['interval'])[1]] = [
                        'position' => $position,
                        'league'   => $league
                    ];
                }
            }
        }
        return $positions;
    }
    private function getPosition($item)
    {
        $symbols = ['th', 'st', 'rd', 'nd'];
        foreach ($symbols as $symbol) {
            if ($i = strpos($item, $symbol)) {
                return substr($item, 0, $i);
            }
        }
        return $item;
    }
}
