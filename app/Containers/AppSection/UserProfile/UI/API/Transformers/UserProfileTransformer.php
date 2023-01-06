<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Transformers;

use App\Containers\AppSection\UserProfile\Models\UserProfile;
use App\Ship\Parents\Transformers\Transformer;

class UserProfileTransformer extends Transformer
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

    public function transform(UserProfile $userprofile): array
    {
        $response = [
            'object' => $userprofile->getResourceKey(),
            'group' => $userprofile->group,
            'key' => $userprofile->key,
            'value' => $userprofile->value,
        ];

        return $response = $this->ifAdmin([
            'real_id'    => $userprofile->id,
            // 'deleted_at' => $userprofile->deleted_at,
        ], $response);
    }
}
