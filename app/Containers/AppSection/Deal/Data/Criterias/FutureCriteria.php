<?php

namespace App\Containers\AppSection\Deal\Data\Criterias;

use App\Containers\AppSection\Deal\Enums\DealType;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class FutureCriteria extends Criteria
{
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where('deal_type', '=', DealType::FUTURE);
    }
}
