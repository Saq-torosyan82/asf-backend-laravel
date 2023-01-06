<?php

namespace App\Containers\AppSection\Deal\UI\API\Transformers;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Ship\Parents\Transformers\Transformer;

class SummaryDealTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    public function transform(Deal $deal): array
    {
        return [
            'id' => $deal->getHashedKey(),
            'deal_type' => $deal->deal_type,
            'contract_type' => $deal->contract_type,
            'status' => $deal->status,
            'status_label' => DealStatus::getDescription($deal->status),
            'reason' => $deal->reason,
            'reason_label' => StatusReason::getDescription($deal->reason),
            'contract_amount' => $deal->contract_amount,
            'currency' => $deal->currency,
            'deal_amount' => $deal->deal_amount,
            'funding_date' => $deal->funding_date
        ];
    }
}
