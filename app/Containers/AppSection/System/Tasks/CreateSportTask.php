<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateSportTask extends Task
{
    protected SportRepository $repository;

    public function __construct(SportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($sport_id, $sport_name, $is_active)
    {
        try {
            return $this->repository->create(
                [
                    'id' => $sport_id,
                    'name' => $sport_name,
                    'is_active' => $is_active
                ]
            );
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
