<?php

namespace App\Containers\AppSection\UserSponsorship\Tasks;

use App\Containers\AppSection\UserSponsorship\Data\Repositories\UserSponsorshipRepository;
use App\Ship\Parents\Tasks\Task;

class FindlUserSponsorshipsByTypeTask extends Task
{
    protected UserSponsorshipRepository $repository;

    public function __construct(UserSponsorshipRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId, string $type, int $sponsorId)
    {
        return $this->repository->findWhere([
            'user_id' => $userId,
            'type' => $type,
            'entity_id' => $sponsorId
        ])->first();
    }
}
