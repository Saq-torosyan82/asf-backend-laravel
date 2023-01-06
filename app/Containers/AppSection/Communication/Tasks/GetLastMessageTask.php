<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\MessageRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetLastMessageTask extends Task
{
    protected MessageRepository $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($comId)
    {
        try {
            return $this->repository
                ->where('communication_id', $comId)
                ->orderBy('created_at', 'DESC')
                ->first();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
