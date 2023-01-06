<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Tasks\GetAllDealsTask;
use App\Containers\AppSection\Deal\Tasks\GetAllLenderDealsTask;
use App\Containers\AppSection\Deal\Tasks\GetAllLenderOffersTask;
use App\Containers\AppSection\Deal\Tasks\GetDealsByUserIdTask;
use App\Ship\Exceptions\ConflictException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetLenderSuccessRateAction extends Action
{
    public function run($userId)
    {
        if (empty($userId)) throw new ConflictException('the user is missing');

        // get all lender offers
        $lenderOffersNb = app(GetAllLenderOffersTask::class)->offerBy($userId)->run()->count();

        // get acceoted deals
        $lenderAcceptedOffers = app(GetAllLenderOffersTask::class)->offerBy($userId)->accepted()->run();

        $ids = [];
        foreach ($lenderAcceptedOffers as $row) {
            $ids[] = $row->deal_id;
        }

        $success_rate = 0;
        $liveDealsNb = 0;

        if (count($ids)) {
            $liveDealsNb = app(GetAllDealsTask::class)->contractSigned()->ids($ids)->run()->count();
            if ($liveDealsNb) {
                $success_rate = round($liveDealsNb * 100 / $lenderOffersNb);
            }
        }

        return [
            'nb_terms' => $lenderOffersNb,
            'nb_live_deals' => $liveDealsNb,
            'success_rate' => $success_rate
        ];
    }
}
