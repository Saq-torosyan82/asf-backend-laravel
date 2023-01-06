<?php

namespace App\Containers\AppSection\UserSponsorship\Tasks;

use App\Containers\AppSection\UserSponsorship\Data\Repositories\ClubSponsorRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateClubSponsorTask extends Task
{
    protected ClubSponsorRepository $repository;

    public function __construct(ClubSponsorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(array $data)
    {
        try {
            return $this->repository->create($data);
        }catch (Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }
    }
}
