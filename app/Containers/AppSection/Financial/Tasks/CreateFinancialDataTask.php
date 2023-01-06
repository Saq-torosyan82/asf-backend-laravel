<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialDataRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateFinancialDataTask extends Task
{
    protected FinancialDataRepository $repository;

    public function __construct(FinancialDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $financialId, int $financialItemId, $amount)
    {
        try {
            return $this->repository->create([
                'financial_id' => $financialId,
                'item_id' => $financialItemId,
                'amount' => $amount
            ]);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
