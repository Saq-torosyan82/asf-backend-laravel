<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialDocumentRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateDocumentsStatusTask extends Task
{
    protected FinancialDocumentRepository $repository;

    public function __construct(FinancialDocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, $data)
    {
        try {
            return $this->repository->update($data, $id);
        }
        catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
