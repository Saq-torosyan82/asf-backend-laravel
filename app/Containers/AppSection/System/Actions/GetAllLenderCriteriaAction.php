<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\GetAllLenderCriteriaTask;
use App\Containers\AppSection\System\UI\API\Requests\GetAllLenderCriteriaRequest;
use App\Ship\Parents\Actions\Action;

class GetAllLenderCriteriaAction extends Action
{
    public function run(GetAllLenderCriteriaRequest $request)
    {
        $lenderCriteria = app(GetAllLenderCriteriaTask::class)->addRequestCriteria()->run()->groupBy('type');
        $result = [];
        foreach($lenderCriteria as $key => $type) {
            $result[$key] = [];
            foreach($type as $criterion) {
                $result[$key][] = [
                    'id' => $criterion->getHashedKey(),
                    'name' => $criterion->value
                ];
            }
        }
        return $result;
    }
}
