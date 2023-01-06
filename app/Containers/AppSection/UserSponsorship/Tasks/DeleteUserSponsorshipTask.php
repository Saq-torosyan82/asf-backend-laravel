<?php

namespace App\Containers\AppSection\UserSponsorship\Tasks;

use App\Containers\AppSection\UserSponsorship\Data\Repositories\UserSponsorshipRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteUserSponsorshipTask extends Task
{
    protected UserSponsorshipRepository $repository;

    public function __construct(UserSponsorshipRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId, int $sponsorshipId): ?int
    {
        try {
            return $this->repository->where(['user_id' => $userId, 'id' => $sponsorshipId])->delete();
        }
        catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
