<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Transformers;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\UserProfile\Enums\Key;

class BasicUserInfoTransformer extends Transformer
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

    public function transform(User $user): array
    {
        $borrowerType = $user->UserProfile->where('key', Key::BORROWER_TYPE)->first();

        return [
            'id' => $user->getHashedKey(),
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'user_type' => is_null($user->roles->first()) ? '' : $user->roles->first()->name,
            'borrower_type' => $borrowerType != null ? $borrowerType->value : ''
        ];
    }
}
