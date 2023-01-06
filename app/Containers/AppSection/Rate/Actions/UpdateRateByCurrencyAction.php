<?php

namespace App\Containers\AppSection\Rate\Actions;

use App\Containers\AppSection\Rate\Tasks\UpdateRateByCurrencyTask;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\Rate\Enums\Configs;
use Log;

class UpdateRateByCurrencyAction extends Action
{
    /**
     * @return mixed|void
     */
    public function run()
    {
        try {
            $req_url = Configs::ENDPOINT_URL . Configs::BASE_CURRENCY;
            $response = json_decode(file_get_contents($req_url), true);
            if ($response && !empty($response['rates'])) {
                $response['rates'][Configs::BASE_CURRENCY] = 1;
                app(UpdateRateByCurrencyTask::class)->run($response['rates']);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
