<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Models\LenderDealCriteria;
use App\Containers\AppSection\UserProfile\Tasks\CreateLenderDealCriteriaTask;
use App\Containers\AppSection\UserProfile\Tasks\CreateLenderDealCriterionCountryTask;
use App\Containers\AppSection\UserProfile\Tasks\CreateLenderDealCriterionCurrencyTask;
use App\Containers\AppSection\UserProfile\Tasks\CreateLenderDealCriterionSportTask;
use App\Containers\AppSection\UserProfile\Exceptions\MissingUserException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class CreateLenderDealCriteriaAction extends Action
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
                'note',
                'currency',
                'country',
                'sport',
            ]
        );

        $user = $request->user();
        $userId = $user->id;
        if($user->isAdmin())
        {
            if(!$request->has('user_id'))
            {
                throw new MissingUserException();
            }
            $userId = $request->user_id;
        }

        try {
            $lenderDealCriteria = app(CreateLenderDealCriteriaTask::class)->run(
                $userId,
                $data['type']['id'],
                $data['min_amount']['id'],
                $data['max_amount']['id'],
                $data['min_tenor']['id'],
                $data['max_tenor']['id'],
                $data['min_interest_rate']['id'],
                $data['interest_range']['id'],
                $data['note']
            );

            // add currency
            foreach ($data['currency'] as $currency) {
                app(CreateLenderDealCriterionCurrencyTask::class)->run(
                    $lenderDealCriteria->id,
                    $currency['id']
                );
            }

            // add country
            foreach ($data['country'] as $country) {
                app(CreateLenderDealCriterionCountryTask::class)->run(
                    $lenderDealCriteria->id,
                    $country['id']
                );
            }

            // add sport
            foreach ($data['sport'] as $sport) {
                app(CreateLenderDealCriterionSportTask::class)->run(
                    $lenderDealCriteria->id,
                    $sport['id']
                );
            }
        } catch (\Exception $e) {
            throw $e;
        }


        return $lenderDealCriteria;
    }
}
