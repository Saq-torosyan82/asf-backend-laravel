<?php

namespace App\Containers\AppSection\Rate\Tasks;

use App\Containers\AppSection\Rate\Data\Repositories\RateRepository;
use App\Containers\AppSection\System\Enums\Currency;
use App\Ship\Parents\Tasks\Task;

class GetAllRatesTask extends Task
{
    protected RateRepository $repository;

    public function __construct(RateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        $res = $this->repository->findWhereIn('currency', [
            Currency::getDescription(Currency::EUR),
            Currency::getDescription(Currency::USD)
        ])->all();
        $rates = [];
        foreach ($res as $row) {
            $rates[$row->currency] = $row->value;
        }
        return $rates;
    }
}
