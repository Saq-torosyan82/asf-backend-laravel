<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\CommunicationRepository;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindByIdTask extends Task
{
    protected CommunicationRepository $repository;

    public function __construct(CommunicationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            $communication =  $this->repository->find($id);
            $communication['deal'] = isset($communication->deal_id) ? app(FindDealByIdTask::class)->run($communication->deal_id) : [];
            $communication['participants'] = app(GetParticipantsInfoTask::class)->run($id);

            return $communication;
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
