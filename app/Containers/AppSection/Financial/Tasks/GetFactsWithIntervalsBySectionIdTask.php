<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FactNameRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FactValueRepository;
use App\Ship\Parents\Tasks\Task;

class GetFactsWithIntervalsBySectionIdTask extends Task
{
    protected FactNameRepository $factNameRepository;
    protected FactValueRepository $factValueRepository;

    public function __construct(FactNameRepository $factNameRepository, FactValueRepository $factValueRepository)
    {
        $this->factNameRepository = $factNameRepository;
        $this->factValueRepository = $factValueRepository;
    }

    public function run($club_id, $section_id, $intervalIds)
    {
        return $this->factValueRepository->select('fact_names.id', 'fact_names.name as label','fact_values.fact_interval_id','fact_intervals.interval','fact_values.value', 'fact_intervals.index')
                ->leftJoin('fact_names', 'fact_names.id', '=', 'fact_values.fact_name_id')
            ->leftJoin('fact_intervals', 'fact_intervals.id','=','fact_values.fact_interval_id')
            ->when(is_array($section_id), function($query) use($section_id) {
                return $query->whereIn('fact_names.factsection_id', $section_id);
            })
            ->when(!is_array($section_id), function($query) use($section_id) {
                return $query->where('fact_names.factsection_id', $section_id);
            })
            ->where('fact_values.club_id', '=', $club_id)
            ->whereIn('fact_values.fact_interval_id', $intervalIds)
            ->OrderBy('fact_intervals.index','DESC')->distinct()->get()->toArray();
    }
}
