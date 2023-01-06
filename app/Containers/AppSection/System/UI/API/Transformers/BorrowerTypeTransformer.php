<?php

namespace App\Containers\AppSection\System\UI\API\Transformers;

use App\Containers\AppSection\System\Models\BorrowerType;
use App\Ship\Parents\Transformers\Transformer;

class BorrowerTypeTransformer extends Transformer
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

    public function transform(BorrowerType $borrowertype): array
    {
        $response = [
            'id' => $borrowertype->getHashedKey(),
            'name' => $borrowertype->name,
            'label' => \App\Containers\AppSection\System\Enums\BorrowerType::getDescription($borrowertype->name),
            'type' => $borrowertype->type,
        ];

        return $response = $this->ifAdmin([
            'real_id'    => $borrowertype->id,
        ], $response);
    }
}
