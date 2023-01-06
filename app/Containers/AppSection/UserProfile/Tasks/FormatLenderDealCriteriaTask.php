<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\System\Tasks\GetAllCountriesTask;
use App\Containers\AppSection\System\Tasks\GetAllLenderCriteriaTask;
use App\Containers\AppSection\System\Tasks\GetAllSportsTask;
use App\Containers\AppSection\UserProfile\Data\Repositories\LenderDealCriteriaRepository;
use App\Ship\Parents\Tasks\Task;

class FormatLenderDealCriteriaTask extends Task
{
    use HashIdTrait;

    public function run($user_id)
    {
        // get all lender criteria
        $lenderCriteria = app(GetAllLenderCriteriaTask::class)->run();
        foreach ($lenderCriteria as $row) {
            $criteriaData[$row->id] = $row;
        }

        // get all sports
        $res = app(GetAllSportsTask::class)->run();
        $sportData = [];
        foreach($res as $row)
        {
            $sportData[$row->id] = $row;
        }

        // get all countried
        $res = app(GetAllCountriesTask::class)->run();
        $countryData = [];
        foreach($res as $row)
        {
            $countryData[$row->id] = $row;
        }

        $dealCriteria = app(GetLenderDealCriteriaTask::class)->run($user_id);
        $keys = [
            'type' => 'type',
            'min_amount' => 'min_amount',
            'max_amount' => 'max_amount',
            'min_tenor' => 'min_tenor',
            'max_tenor' => 'max_tenor',
            'min_interest_rate' => 'min_interest_rate',
            'interest_range' => 'interest_range',
        ];
        $data = [];
        foreach ($dealCriteria as $deal) {
            $row = [
                'id' => $deal->getHashedKey()
            ];

            foreach ($keys as $k => $v) {
                $row[$k] = [
                    'id' => $this->encode($deal->$v),
                    'name' => $criteriaData[$deal->$v]->value
                ];
            }
            $row['note'] = $deal->note;

            // get currencies
            foreach($deal->currencies as $rrow)
            {
               $row['currency'][] = [
                   'id' => $this->encode($rrow->currency_id),
                   'name' => $criteriaData[$rrow->currency_id]->value
               ];
            }

            // get countries
            foreach($deal->countries as $rrow)
            {
                $row['country'][] = [
                    'id' => $this->encode($rrow->country_id),
                    'name' => $countryData[$rrow->country_id]->name
                ];
            }

            // get sports
            foreach($deal->sports as $rrow)
            {
                $row['sport'][] = [
                    'id' => $this->encode($rrow->sport_id),
                    'name' => $sportData[$rrow->sport_id]->name
                ];
            }

            $data[] = $row;
        }

        return $data;
    }
}
