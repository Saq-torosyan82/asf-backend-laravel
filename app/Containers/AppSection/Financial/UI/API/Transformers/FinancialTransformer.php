<?php

namespace App\Containers\AppSection\Financial\UI\API\Transformers;

use App\Containers\AppSection\Financial\Models\Financial;
use App\Ship\Parents\Transformers\Transformer;

class FinancialTransformer extends Transformer
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

    public function transform(Financial $financial): array
    {
        $response = [
            'object' => $financial->getResourceKey(),
            'id' => $financial->getHashedKey(),
            'created_at' => $financial->created_at,
            'updated_at' => $financial->updated_at,
            'readable_created_at' => $financial->created_at->diffForHumans(),
            'readable_updated_at' => $financial->updated_at->diffForHumans(),

        ];

        return $response = $this->ifAdmin([
            'real_id'    => $financial->id,
            // 'deleted_at' => $financial->deleted_at,
        ], $response);
    }
}
