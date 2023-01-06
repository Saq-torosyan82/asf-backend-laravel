<?php

namespace App\Containers\AppSection\Rate\UI\API\Transformers;

use App\Containers\AppSection\Rate\Models\Rate;
use App\Ship\Parents\Transformers\Transformer;

class RateTransformer extends Transformer
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

    /**
     * @param Rate $rate
     * @return array
     */
    public function transform(Rate $rate): array
    {
        $response = [
            'currency' => $rate->currency,
            'value'    => $rate->value,
        ];

        return $response = $this->ifAdmin(['real_id' => $rate->id], $response);
    }
}
