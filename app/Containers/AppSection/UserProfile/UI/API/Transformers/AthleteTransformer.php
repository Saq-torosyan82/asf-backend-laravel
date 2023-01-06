<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Transformers;

use App\Containers\AppSection\Upload\Tasks\GetUserAvatarUrlTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\System\Tasks\FindSportClubTask;

class AthleteTransformer extends Transformer
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
        $club = null;
        $group = $user->UserProfile->where('key', Key::CLUB)->where('group', Group::PROFESSIONAL)->first();
        if ($group != null) {
            $club = app(FindSportClubTask::class)->run(['id' => $group->value])->first();
        }

        $response = [
            'id' => $user->getHashedKey(),
            'name' => $user->first_name . ' ' . $user->last_name,
            'club' => $club != null ? $club->name : '',
            'avatar' => app(GetUserAvatarUrlTask::class)->run($user->id),
            'agent_name' => $user->Parent ? $user->Parent->first_name.' '.$user->Parent->last_name: '',
        ];

        return $response;
    }
}
