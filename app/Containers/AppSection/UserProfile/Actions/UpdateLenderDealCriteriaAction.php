<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Models\LenderDealCriteria;
use App\Containers\AppSection\UserProfile\Tasks\UpdateLenderDealCriteriaTask;
use App\Containers\AppSection\UserProfile\Tasks\UpdateLenderDealCriterionCountryTask;
use App\Containers\AppSection\UserProfile\Tasks\UpdateLenderDealCriterionCurrencyTask;
use App\Containers\AppSection\UserProfile\Tasks\UpdateLenderDealCriterionSportTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdateLenderDealCriteriaAction extends Action
{
    public function run(Request $request): LenderDealCriteria
    {
        // update main data
        $data = $request->sanitizeInput(
            [
                'type',
                'min_amount',
                'max_amount',
                'min_tenor',
                'max_tenor',
                'min_interest_rate',
                'interest_range',
                //'note',
            ]
        );

        $upData = [];
        foreach ($data as $key => $row) {
            $upData[$key] = $row['id'];
        }

        // get note
        $data = $request->sanitizeInput(
            [
                'note',
            ]
        );
        $upData = array_merge($upData, $data);

        $res = app(UpdateLenderDealCriteriaTask::class)->run($request->lender_deal_criteria_id, $upData);

        // update seccondary tables
        $data = $request->sanitizeInput(
            [
                'currency',
                'country',
                'sport',
            ]
        );

        // update country criteria
        app(UpdateLenderDealCriterionCountryTask::class)->run($request->lender_deal_criteria_id, $data['country']);

        // update currency criteria
        app(UpdateLenderDealCriterionCurrencyTask::class)->run($request->lender_deal_criteria_id, $data['currency']);

        // update sport criteria
        app(UpdateLenderDealCriterionSportTask::class)->run($request->lender_deal_criteria_id, $data['sport']);

        return $res;
    }
}
