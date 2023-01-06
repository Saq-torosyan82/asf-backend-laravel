<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportLeagueRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetSportLeagueByIdTask extends Task
{
    protected SportLeagueRepository $repository;

    /**
     * @param SportLeagueRepository $repository
     */
    public function __construct(SportLeagueRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return mixed
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
