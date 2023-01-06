<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\Upload\Data\Repositories\UserDocumentRepository;
use App\Containers\AppSection\Upload\Exceptions\DocumentNotFoundException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteUserDocumentTask extends Task
{
    protected UserDocumentRepository $repository;

    public function __construct(UserDocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($uuid)
    {
        try {
            // get user document
            $userDocument = $this->repository->findWhere([
                'uuid' => $uuid
            ])->first();

            if(is_null($userDocument))
            {
                throw new DocumentNotFoundException();
            }

            app(SoftDeleteUploadTask::class)->run($userDocument->upload_id);

            return $this->repository->delete($userDocument->id);
        }
        catch (Exception $exception) {
            throw $exception;
        }
    }
}
