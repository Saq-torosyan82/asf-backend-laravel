<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\Upload\Data\Repositories\UserDocumentRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindUserDocumentByTypeTask extends Task
{
    protected UserDocumentRepository $repository;

    public function __construct(UserDocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId, string $type)
    {
        try {
            return $this->repository->findWhere([
                'user_id' => $userId,
                'type' => $type
            ])->first();
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
