<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyLogoTask;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyNameTask;
use App\Containers\AppSection\Deal\Tasks\GetDealProgressPercentageTask;
use App\Containers\AppSection\Payment\Tasks\GetPaymentsByDealIdTask;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Containers\AppSection\System\Enums\Currency;
use App\Containers\AppSection\System\Enums\LenderCriteriaType;
use App\Containers\AppSection\System\Tasks\GetCountryByIdTask;
use App\Containers\AppSection\Upload\Tasks\GetUploadsByIdsTask;
use App\Containers\AppSection\User\Tasks\GetUsersByIdsTask;
use \App\Containers\AppSection\Deal\Tasks\GetLenderDealsTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\System\Tasks\GetLenderCriteriaByTypeTask;
use App\Containers\AppSection\UserProfile\Tasks\GetUsersProfileByKeyAndValueTask;
use App\Containers\AppSection\UserProfile\Tasks\GetUsersProfileByKeyTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Helpers as helpers;
use Illuminate\Support\Carbon;
use App\Ship\Parents\Requests\Request;

class GetAllLendersAction extends Action
{
    use HashIdTrait;

    public function run(Request $request, $encode_id = false)
    {
        $currentTime = Carbon::now();

        // get all lender type
        $res = app(GetLenderCriteriaByTypeTask::class)->run(LenderCriteriaType::LENDER_TYPE);
        $lenderType = [];
        foreach ($res as $row) {
            $lenderType[$row->id] = $row->value;
        }

        $res = app(GetUsersProfileByKeyAndValueTask::class)->run(Group::ACCOUNT, Key::LENDER_TYPE);
        $profiles = [];
        foreach ($res as $row) {
            $profiles[$row->user_id] = isset($lenderType[$row->value]) ? $lenderType[$row->value] : '';

        }

        // get all avatars
        $res = app(GetUsersProfileByKeyTask::class)->run(Group::USER, Key::AVATAR, array_keys($profiles));
        $avatars = [];
        foreach ($res as $row) {
            $avatars[$row->user_id] = $row->value;
        }

        // get download links
        $res = app(GetUploadsByIdsTask::class)->run(array_values($avatars));
        $downloads = [];
        foreach ($res as $row) // get bulk files
        {
            $downloads[$row->user_id] = downloadUrl($row->uuid);
        }

        // get bulk users
        $res = app(GetUsersByIdsTask::class)->run(array_keys($profiles));
        $users = [];
        foreach ($res as $row) {
            if(!$row->is_active){
                continue;
            }

            $users[$row->id] = $row;
        }
        $res =  app(GetUsersProfileByKeyAndValueTask::class)->run(Group::COMPANY, Key::COUNTRY);
        $countries = [];
        foreach ($res as $row) {
            if(!isset($users[$row->user_id])){
                continue;
            }

            $countries[$row->user_id] = app(GetCountryByIdTask::class)->run($row->value)->name;
        }
        $rates = app(GetAllRatesTask::class)->run();

        // add name, avatar, deals
        foreach ($profiles as $user_id => $row) {
            // remove inactive users
            if(!isset($users[$user_id])){
                continue;
            }
            $userDeals = app(GetLenderDealsTask::class)->run($user_id);
            $terms = $userDeals->count();
            $startedDeals = 0;
            $totalAmount = 0;
            $payments = 0;
            $deals = [];

            foreach ($userDeals as $dealData) {
                $receivedMoney[$dealData->deal->id]['count'] = 0;
                $payment = 0;
                $startedDeals ++;
                $currencyTo = $request->selected_currency ?: $dealData->deal->currency;
                $dealAmount = helpers\exchangeRate($dealData->deal->currency, $currencyTo, $dealData->deal->contract_amount, $rates);

                if (!$request->selected_currency) {
                    $totalAmount += helpers\exchangeRate($dealData->deal->currency, Currency::getDescription(Currency::GBP), $dealData->deal->contract_amount, $rates);
                } else {
                    $totalAmount += $dealAmount;
                }

                $paymentDatas = app(GetPaymentsByDealIdTask::class)->run($dealData->deal->id);
                if ($paymentDatas->count()) {
                    foreach ($paymentDatas as $paymentData){
                        if ($paymentData->is_paid) {
                            $payment = helpers\exchangeRate($dealData->deal->currency, $currencyTo, $paymentData->amount, $rates);
                            $receivedMoney[$dealData->deal->id]['count']++;
                            if (!$request->selected_currency) {
                                $payments += helpers\exchangeRate($dealData->deal->currency, Currency::getDescription(Currency::GBP), $paymentData->amount, $rates);
                            } else {
                                $payments += $payment;
                            }
                        }
                    }
                }

                if (!empty($dealData->deal->payments_data)) {
                    $paymentData = date('Y-m-d', strtotime($dealData->deal->payments_data[count($dealData->deal->payments_data) - 1]['paymentDate']));
                } else {
                    $paymentData = '';
                }
                $lender = $dealData->deal->offers->count() ? $dealData->deal->offers->first()->user->first_name . ' ' . $dealData->deal->offers->first()->user->last_name : '';
                $borrower = $dealData->deal->user->first_name . ' ' . $dealData->deal->user->last_name;
                $deals[] = [
                    'deal_id' => $this->encode($dealData->deal->id),
                    'currency' => $currencyTo,
                    'contract_amount' => number_format($dealAmount,2),
                    'payment' => number_format($payment,2),
                    'outstanding' => number_format($dealAmount - $payment, 2),
                    'start_date' => $dealData->deal->funding_date,
                    'finish_date' => $paymentData,
                    'status' => $dealData->deal->status,
                    'borrower' => trim($borrower),
                    'lender' => trim($lender),
                    'counterparty' => [
                        'name' => app(GetCounterpartyNameTask::class)->run($dealData->deal),
                        'avatar' => app(GetCounterpartyLogoTask::class)->run($dealData->deal),
                    ],
                    'reason' => $dealData->deal->reason,
                    'reason_label' => StatusReason::getDescription($dealData->deal->reason),
                    "status_bar" => [
                        "percentaje" => app(GetDealProgressPercentageTask::class)->run($dealData->deal),
                        "label" => StatusReason::getDescription($dealData->deal->reason)
                    ],
                    'nb_installments' => $dealData->deal->nb_installmetnts,
                    'paid_installments' => $receivedMoney[$dealData->deal->id]['count'],
                    'is_past' => $dealData->deal->nb_installmetnts === $receivedMoney[$dealData->deal->id]['count'],
                ];
            }
            $name = isset($users[$user_id]) ? $users[$user_id]->first_name . ' ' . $users[$user_id]->last_name : '';

            $data[] = [
                'id' => $encode_id ? $this->encode($user_id) : $user_id,
                'name' => trim($name),
                'avatar' => isset($downloads[$user_id]) ? $downloads[$user_id] : '',
                'type' => $row,
                'country' => $countries[$user_id],
                'started_deals' => $startedDeals,
                'terms_accepted' => $terms,
                'success_rate' => $terms == 0 ? $startedDeals : $startedDeals / $terms,
                'currency' => $request->selected_currency ?: Currency::getDescription(Currency::GBP),
                'amount' => number_format($totalAmount, 2),
                'outstanding' => number_format($totalAmount - $payments, 2),
                'deals' => $deals
            ];
        }

        return $data;
    }
}
