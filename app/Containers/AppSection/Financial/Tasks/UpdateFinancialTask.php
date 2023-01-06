<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateFinancialTask extends Task
{
    protected FinancialRepository $repository;

    public function __construct(FinancialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data)
    {
        try {            
            return $this->repository->update($data, $id);
        }
        catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
