<?php

namespace App\Containers\AppSection\Deal\Data\Criterias;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class ContractSignedCriteria extends Criteria
{
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where('status', '=', DealStatus::STARTED)
            ->where('reason', '=', StatusReason::CONTRACT_SIGNED);
    }
}
