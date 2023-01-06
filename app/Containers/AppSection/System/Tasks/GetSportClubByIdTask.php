<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Models\SportClub;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;

class GetSportClubByIdTask extends Task
{

    protected SportClub $repository;

    public function __construct(SportClub $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws NotFoundException
     */
    public function run($id)
    {
        try {
            return $this->repository->findByField('id', $id)->first();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
