<?php

namespace App\Containers\AppSection\Deal\Data\Criterias;


use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class CurrentCriteria extends Criteria
{
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(function ($query) {
            $query->where('deal_offers.status', '=', OfferStatus::NEW)
                ->orWhere(function ($query) {
                    $query->where('deal_offers.status', '=', OfferStatus::ACCEPTED)
                        ->where(function ($query) {
                            $query->whereHas('deal', function ($query) {
                                $query->where(function ($query) {
                                    $query->where('deals.status', '=', DealStatus::STARTED)
                                        ->where('deals.reason', '=', StatusReason::CONTRACT_SIGNED);
                                })
                                    ->orWhere(function ($query) {
                                        $query->where('deals.status', '=', DealStatus::IN_PROGRESS)
                                            ->whereIn('deals.reason', [StatusReason::CONTRACT_ISSUED, StatusReason::SIGNED_BORROWER]);
                                    })
                                    ->orWhere(function ($query) {
                                        $query->where('deals.status', '=', DealStatus::ACCEPTED)
                                            ->whereIn('deals.reason', [StatusReason::ACCEPTED_BORROWER]);
                                    });
                            });
                        });
                });
        });
    }
}
