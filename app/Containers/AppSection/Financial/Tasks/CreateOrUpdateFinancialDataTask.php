<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialDataRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FinancialItemRepository;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Ship\Parents\Tasks\Task;
use Exception;
use App\Ship\Helpers as helpers;

class CreateOrUpdateFinancialDataTask extends Task
{
    protected FinancialDataRepository $repository;
    protected FinancialItemREpository $financialItemRepository;

    public function __construct(FinancialDataRepository $repository,
                                FinancialItemRepository $financialItemRepository)
    {
        $this->repository = $repository;
        $this->financialItemRepository = $financialItemRepository;
    }

    public function run(int $financialId, array $data, $currencyFrom, $currencyTo)
    {
        $items = $this->financialItemRepository->pluck('id')->toArray();
        $rates = app(GetAllRatesTask::class)->run();
        foreach ($data as $item) {
            if (in_array($item['item_id'], $items)) {
                try {
                    $this->repository->updateOrCreate([
                        'financial_id' => $financialId,
                        'item_id' => $item['item_id']
                    ], [
                        'amount' => helpers\exchangeRate($currencyFrom, $currencyTo, $item['amount'], $rates)
                    ]);
                }
                catch (Exception $exception) {
                    throw new Exception('Failed to create/update Resource');
                }
            } else {
                throw new Exception("Financial item with ". $item['item_id'] ." id doesn't exist" );
            }
        }
    }
}
