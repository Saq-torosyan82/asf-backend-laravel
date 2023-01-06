<?php

namespace App\Containers\AppSection\System\UI\API\Transformers;

use App\Containers\AppSection\System\Models\Country;
use App\Ship\Parents\Transformers\Transformer;

class CountryTransformer extends Transformer
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

    public function transform(Country $country): array
    {
        $response = [
            'id' => $country->getHashedKey(),
            'name' => $country->name,
        ];

        $response = $this->ifAdmin([
            'real_id'    => $country->id,
        ], $response);

        return $response;
    }
}
