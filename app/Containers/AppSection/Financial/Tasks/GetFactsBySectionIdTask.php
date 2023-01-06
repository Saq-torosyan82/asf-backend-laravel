<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FactNameRepository;
use App\Ship\Parents\Tasks\Task;

class GetFactsBySectionIdTask extends Task
{
    protected FactNameRepository $factNameRepository;

    public function __construct(FactNameRepository $factNameRepository)
    {
        $this->factNameRepository = $factNameRepository;
    }

    public function run($club_id, $section_id = null, $withNull = false)
    {
        return $this->factNameRepository->select('fact_names.name',
            'fact_values.value','fact_names.factsection_id')
            ->leftJoin('fact_values', function($join) use($club_id) {
                $join->on('fact_names.id', '=', 'fact_values.fact_name_id');
                $join->where('fact_values.club_id', '=', $club_id);
            })
            ->when(is_array($section_id), function($query) use($section_id) {
                return $query->whereIn('fact_names.factsection_id', $section_id);
            })
            ->when(!is_array($section_id) && $section_id != null, function($query) use($section_id) {
                return $query->where('fact_names.factsection_id', $section_id);
            })
            ->when($withNull || $section_id == null, function($query) use($section_id) {
                return $query->orWhere('fact_names.factsection_id', null);
            })
            ->get()->toArray();
    }
}
