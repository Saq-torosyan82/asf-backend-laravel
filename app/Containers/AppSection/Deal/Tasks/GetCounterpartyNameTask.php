<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Containers\AppSection\Deal\Enums\ContractType;
use App\Ship\Parents\Tasks\Task;

class GetCounterpartyNameTask extends Task
{
    public function run($deal)
    {
        $key = 'club';
        if ($deal->contract_type == ContractType::MEDIA_RIGHTS) {
            $key = 'tvHolder';
        } elseif ($deal->contract_type == ContractType::ENDORSEMENT) {
            $key = 'sponsorOrBrand';
        }

        if (isset($deal->criteria_data[$key]) && isset($deal->criteria_data[$key]['name'])) {
            return $deal->criteria_data[$key]['name'];
        }

        return ''; // this shouldn't happen
    }
}
