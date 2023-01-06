<?php

namespace App\Containers\AppSection\Deal\Data\Criterias;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class MissedCriteria extends Criteria
{
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(function ($query) {
            $query->where('status', '=', OfferStatus::REJECTED)
                ->orWhere(function ($query) {
                    $query->where('status', '=', OfferStatus::ACCEPTED);
                    $query->whereHas('deal', function ($query) {
                        $query->where('status', '!=', DealStatus::STARTED)
                            ->where('reason', '!=', StatusReason::CONTRACT_SIGNED);
                    });
                });
        });
    }
}
