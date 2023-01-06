<?php

namespace App\Containers\AppSection\Deal\UI\API\Transformers;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyNameTask;
use App\Containers\AppSection\Deal\Tasks\FindDealLenderTermByDealAndUserIdTask;
use App\Containers\AppSection\System\Tasks\FindSportClubByIdTask;
use App\Containers\AppSection\System\Tasks\GetAllCountriesTask;
use App\Containers\AppSection\System\Tasks\GetAllSportsTask;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\System\Tasks\GetCountryByIdTask;
use App\Containers\AppSection\System\Tasks\GetLenderCriteriaForDealTask;
use App\Containers\AppSection\System\Tasks\GetSportByIdTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByKeyTask;
use App\Containers\AppSection\UserProfile\Tasks\GetAllUsersProfileByKeyTask;
use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\Deal\Enums\ContractType;
use Illuminate\Support\Facades\Auth;
use Exception;

class LiveDealTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    protected $countries = [];

    protected $sports = [];

    public function __construct()
    {
        $this->setCountries();
        $this->setSports();
    }

    public function transform(Deal $deal): array
    {
        $lender = $deal->offers->count() ? $deal->offers->first()->user->first_name . ' ' . $deal->offers->first()->user->last_name : '';
        $borrower = $deal->user->first_name . ' ' . $deal->user->last_name;
        if (Auth::user()->isAdmin() && $deal->user->isCorporate()) {
            $user_profile_club = app(FindUserProfileByKeyTask::class)->run($deal->user_id, Group::PROFESSIONAL, Key::CLUB);
            $borrower = !is_null($user_profile_club) ? $user_profile_club->value : $borrower;
            if (!is_null($user_profile_club)) {
                try {
                    $borrower = app(FindSportClubByIdTask::class)->run($user_profile_club->value)->name;
                } catch (Exception $e) {
                    $borrower = "";
                }
            }
        }

        $response = [
            'id' => $deal->getHashedKey(),
            'type' => $deal->contract_type,
            'type_label' => ContractType::getDescription($deal->contract_type),
            'status' => $deal->status,
            'status_label' => DealStatus::getDescription($deal->status),
            'country' => $deal->country_id ? app(GetCountryByIdTask::class)->run($deal->country_id)->name : '',
            'start_date' => $deal->funding_date,
            'borrower' => trim($borrower),
            'lender' => trim($lender),
            'sport' => $deal->sport_id ? app(GetSportByIdTask::class)->run($deal->sport_id)->name : '',
            'counterparty' => app(GetCounterpartyNameTask::class)->run($deal),
            'currency' => $deal->currencyTo,
            'contract_amount' => $deal->contract_amount,
            'interest_rate' => $deal->interest_rate,
        ];

        //$user = app(FindUserByIdTask::class)->run($deal->user_id);
        $user = Auth::user();

        if ($user->isLender()) {
            $term = app(FindDealLenderTermByDealAndUserIdTask::class)->run($deal->id, $user->id);
            $response['terms_accepted'] = $term != null ? 1 : 0;
            $lenders = app(GetLenderCriteriaForDealTask::class)->run($deal);
            $matched_criterias = $lenders ?  $lenders['lender_names'] : [];
            $fullName = trim($user->first_name . ' ' . $user->last_name);
            $response['is_matched'] = in_array($fullName, $matched_criterias) ? true : false;
        } else {
            $response['terms_accepted'] = 1;
        }

        return $response;
    }


    protected function setCountries()
    {
        // get all countries
        $countries = [];
        $res = app(GetAllCountriesTask::class)->run();
        foreach ($res as $row) {
            $countries[$row->id] = $row->name;
        }
        $res = app(GetAllUsersProfileByKeyTask::class)->run(Group::ADDRESS, Key::COUNTRY);
        foreach ($res as $row) {
            $this->countries[$row->user_id] = isset($countries[$row->value]) ? $countries[$row->value] : '';
        }
    }

    protected function setSports()
    {
        // get all sports
        $sports = [];
        $res = app(GetAllSportsTask::class)->run();
        foreach ($res as $row) {
            $sports[$row->id] = $row->name;
        }

        // get sport from professional
        $res = app(GetAllUsersProfileByKeyTask::class)->run(Group::PROFESSIONAL, Key::SPORT);
        foreach ($res as $row) {
            $this->sports[$row->user_id] = isset($sports[$row->value]) ? $sports[$row->value] : '';
        }

        // get data from sport list
        $res = app(GetAllUsersProfileByKeyTask::class)->run(Group::COMPANY, Key::SPORTS_LIST);
        foreach ($res as $row) {
            $cList = json_decode($row->value, true);
            if (isset($this->sports[$row->user_id]) || !count($cList)) {
                continue;
            }

            // get first country --> SEEMEk: fix here
            $this->sports[$row->user_id] = isset($sports[$cList[0]]) ? $sports[$cList[0]] : '';
        }
    }
}
