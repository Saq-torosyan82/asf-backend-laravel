<?php

namespace App\Containers\AppSection\UserSponsorship\Tasks;

use App\Containers\AppSection\UserSponsorship\Data\Repositories\UserSponsorshipRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;
use Exception;

class CreateUserSponsorshipTask extends Task
{
    protected UserSponsorshipRepository $repository;

    public function __construct(UserSponsorshipRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId, string $type, int $entityId , $startDate = null, $endDate = null )
    {
        try {
            return $this->repository->create([
                "user_id" => $userId,
                "type" => $type,
                "entity_id" => $entityId,
                "start_date" => $startDate ? Carbon::parse($startDate)->format('Y-m-d') : null,
                "end_date" => $endDate ? Carbon::parse($endDate)->format('Y-m-d') : null,
            ]);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }
    }
}
