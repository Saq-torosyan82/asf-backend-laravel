<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Containers\AppSection\System\Enums\Currency;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Helpers as helpers;

class GetDealsByCounterpartyTask extends Task
{
    protected DealRepository $repository;

    public function __construct(DealRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($counterparty)
    {
        $rates = app(GetAllRatesTask::class)->run();
        $currencyTo = Currency::getDescription(Currency::GBP);

        $res =  $this->repository->select('contract_amount', 'currency', 'counterparty', 'status')
            ->where('counterparty', $counterparty)->get()->toArray();

        $data = [];
        $totalAmount = 0;
        foreach ($res as $item) {
            $amount = helpers\exchangeRate($item['currency'], $currencyTo, $item['contract_amount'], $rates);
            $totalAmount += $amount;
            if (!array_key_exists($item['counterparty'], $data)) {
                $data[$item['counterparty']] = [];
            }
            if (!array_key_exists($item['status'], $data[$item['counterparty']])) {
                $data[$item['counterparty']][$item['status']] = [
                    'status' => DealStatus::getDescription($item['status']),
                    'currency' => $currencyTo,
                    'amount' => $amount
                ];
            } else {
                $data[$item['counterparty']][$item['status']]['amount'] += $amount;
            }
        }
        return [
            'data' => $data,
            'totalAmount' => $totalAmount
        ];
    }
}
