<?php

namespace App\Containers\AppSection\Deal\UI\API\Transformers;

use App\Containers\AppSection\Deal\Models\DealOffer;
use App\Ship\Parents\Transformers\Transformer;

class DealOfferTransformer extends Transformer
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

    public function transform(DealOffer $offer): array
    {
        $dealTransformer = new DealTransformer();
        return $dealTransformer->transform($offer->deal);
    }
}
