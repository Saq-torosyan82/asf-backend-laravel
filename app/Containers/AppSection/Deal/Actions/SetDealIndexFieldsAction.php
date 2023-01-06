<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyNameTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByKeyTask;
use App\Ship\Parents\Actions\Action;

class SetDealIndexFieldsAction extends Action
{
    public function run(Deal $deal)
    {
        // search for country
        $res = app(FindUserProfileByKeyTask::class)->run($deal->user_id, Group::ADDRESS, Key::COUNTRY);
        if (!is_null($res)) {
            // SEEMEk: check if it is int
            $deal->country_id = $res->value;
        }

        // search for sport
        $res = app(FindUserProfileByKeyTask::class)->run($deal->user_id, Group::PROFESSIONAL, Key::SPORT);
        if (!is_null($res)) {
            // SEEMEk: check if it is int
            $deal->sport_id = $res->value;
        } else {
            // get sport from sport_list
            $res = app(FindUserProfileByKeyTask::class)->run($deal->user_id, Group::COMPANY, Key::SPORTS_LIST);
            if (!is_null($res)) {
                $cList = json_decode($res->value, true);
                if (is_array($cList) && count($cList)) {
                    $deal->sport_id = $cList[0];
                }
            }
        }

        // set counterparty
        $counterparty = app(GetCounterpartyNameTask::class)->run($deal);
        if ($counterparty) {
            $deal->counterparty = $counterparty;
        }

        try {
            $deal->save();
        } catch (\Exception $e) {
            throw  $e;
        }

        return true;
    }
}
