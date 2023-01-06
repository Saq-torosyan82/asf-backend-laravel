<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Transformers;

use App\Containers\AppSection\System\Tasks\FindSportClubTask;
use App\Containers\AppSection\Upload\Tasks\GetUserAvatarUrlTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Ship\Parents\Transformers\Transformer;

class AgentsTransformer extends Transformer
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
        $group = $user->UserProfile->where('key', Key::PHONE)->where('group', Group::CONTACT)->first();

        $response = [
            'id' => $user->getHashedKey(),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $group?->value,
            'avatar' => app(GetUserAvatarUrlTask::class)->run($user->id),

        ];

        return $response;
    }
}
