<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Enums\RateType;
use App\Containers\AppSection\Deal\Tasks\GetInterestRatesByEntityTypeAndIdTask;
use App\Ship\Parents\Actions\Action;

class GetInterestRates extends Action
{
    public function run(string $type, int $entity_id)
    {
        $rates = app(GetInterestRatesByEntityTypeAndIdTask::class)->run($type, $entity_id);
        $response = [];
        foreach ($rates as $rate) {
            if (!isset($response[$rate->rate_type])) {
                $response[$rate->rate_type] = [];
            }

            $response[$rate->rate_type][$rate->period] = $rate->amount;
        }

        if (!count($response)) {
            // SEEMEk: should validate entity type
            return $this->getDefaultRates();
        }

        return $response;
    }

    /**
     * @return array[]
     */
    private function getDefaultRates()
    {
        $max_interval = (int)config('appSection-deal.max_interest_interval');
        $default_rate = (float)config('appSection-deal.default_normal_interest_rate');
        $rates = [
            RateType::NORMAL => []
        ];
        for ($i = 1; $i <= $max_interval; $i++) {
            $rates[RateType::NORMAL][$i] = $default_rate;
        }

        return $rates;
    }
}
