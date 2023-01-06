<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialDocumentRepository;
use App\Containers\AppSection\Upload\Exceptions\DocumentNotFoundException;
use App\Containers\AppSection\Upload\Tasks\ForceDeleteUploadTask;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteFinancialDocumentTask extends Task
{
    protected FinancialDocumentRepository $repository;

    public function __construct(FinancialDocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id): ?int
    {
        try {
            $finDocument = $this->repository->findWhere([
                'upload_id' => $id
            ])->first();

            if(!is_null($finDocument))
            {
                $this->repository->delete($finDocument->id);
            }

            return app(ForceDeleteUploadTask::class)->run($id);
        }
        catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
