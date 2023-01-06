<?php

namespace App\Containers\AppSection\Deal\Data\Criterias;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class NotRejectedOffersCriteria extends Criteria
{
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereIn('status', [OfferStatus::NEW, OfferStatus::ACCEPTED]);
    }
}
