<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\CommunicationRepository;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetAllTask extends Task
{
//    use HashIdTrait;
    protected CommunicationRepository $repository;

    public function __construct(CommunicationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($user_id)
    {
        try {
            $communications =  $this->repository->select('communications.id', 'communications.title', 'communications.deal_id', 'communications.question_type', 'communications.created_at', 'communications.type')
                ->leftjoin('communication_participants as cp','cp.communication_id','=','communications.id')
                ->where('cp.user_id', $user_id)
                ->groupBy('communications.id')
                ->orderBy('communications.created_at', 'DESC')
                ->get();
            if (!empty($communications)) {
                foreach ($communications as $communication) {
                    $communication['deal'] = isset($communication->deal_id) ? app(FindDealByIdTask::class)->run($communication->deal_id) : [];
                    $communication['participants'] = app(GetParticipantsInfoTask::class)->run($communication->id);
                    $communication['last_activity'] = app(GetLastMessageTask::class)->run($communication->id)->created_at;
                }
            }
            return $communications;
        } catch (Exception $exception) {
            throw new NotFoundException();
        }

    }
}
