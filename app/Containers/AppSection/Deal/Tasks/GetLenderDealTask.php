<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Containers\AppSection\Deal\Models\DealOffer;
use App\Ship\Parents\Tasks\Task;

class GetLenderDealTask extends Task
{
    protected DealOffer $dealOffer;

    public function __construct(DealOffer $dealOffer)
    {
        $this->dealOffer = $dealOffer;
    }

    public function run($dealId)
    {
        $acceptedOffer = $this->dealOffer->where('deal_id', $dealId)->where('status',OfferStatus::ACCEPTED)->first();
        if($acceptedOffer) {
            return $acceptedOffer->user;
        }

        return null;
    }
}
