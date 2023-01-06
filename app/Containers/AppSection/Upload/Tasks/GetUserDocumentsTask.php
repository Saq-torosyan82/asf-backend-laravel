<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\Upload\Data\Repositories\UserDocumentRepository;
use App\Ship\Parents\Tasks\Task;

class GetUserDocumentsTask extends Task
{
    protected UserDocumentRepository $repository;

    public function __construct(UserDocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId)
    {
        // get all user documents
        return $this->repository->findWhere(
            [
                'user_id' => $userId
            ]
        );
    }
}
