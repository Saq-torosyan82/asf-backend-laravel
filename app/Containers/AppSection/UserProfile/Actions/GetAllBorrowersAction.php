<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyLogoTask;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyNameTask;
use App\Containers\AppSection\Deal\Tasks\GetDealProgressPercentageTask;
use App\Containers\AppSection\Deal\Tasks\GetDealsByUserIdTask;
use App\Containers\AppSection\Payment\Tasks\GetPaymentsByDealIdTask;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\System\Enums\Currency;
use App\Containers\AppSection\System\Tasks\GetAllBorrowerTypesTask;
use App\Containers\AppSection\System\Tasks\GetCountryByIdTask;
use App\Containers\AppSection\System\Tasks\GetSportByIdTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\GetUsersProfileByKeyAndValueTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Carbon;
use App\Ship\Helpers as helpers;

class GetAllBorrowersAction extends Action
{
    use HashIdTrait;

    /**
     * @param $encode_id
     * @return array
     * @throws \App\Ship\Exceptions\NotFoundException
     */
    public function run(Request $request, $encode_id = false)
    {
        $currentTime = Carbon::now();
        $rates = app(GetAllRatesTask::class)->run();
        $res = app(GetAllBorrowerTypesTask::class)->run();
        $borrowerTypes = [];
        foreach ($res as $row) {
            $borrowerTypes[$row->id] = $row->name;
        }

        $res = app(GetUsersProfileByKeyAndValueTask::class)->run(Group::ACCOUNT, Key::BORROWER_TYPE);
        $borrowerModes = [];
        foreach ($res as $row) {
            $borrowerModes[$row->user_id] = $row->value;
        }
        $resByProfessional =  app(GetUsersProfileByKeyAndValueTask::class)->run(Group::PROFESSIONAL, Key::COUNTRY);
        $profCountries = [];
        foreach ($resByProfessional as $row) {
            $profCountries[$row->user_id] = app(GetCountryByIdTask::class)->run($row->value)->name;
        }
        $resByAddress =  app(GetUsersProfileByKeyAndValueTask::class)->run(Group::ADDRESS, Key::COUNTRY);
        $addressCountries = [];
        foreach ($resByAddress as $row) {
            $addressCountries[$row->user_id] = app(GetCountryByIdTask::class)->run($row->value)->name;
        }
        $res =  app(GetUsersProfileByKeyAndValueTask::class)->run(Group::PROFESSIONAL, Key::SPORT);
        $sports = [];
        foreach ($res as $row) {
            $sports[$row->user_id] = app(GetSportByIdTask::class)->run($row->value)->name;
        }

        $res = app(GetUsersProfileByKeyAndValueTask::class)->run(Group::ACCOUNT, Key::BORROWER_MODE_ID);
        $data = [];

        foreach ($res as $row) {
            $user = app(FindUserByIdTask::class)->run($row->user_id);
            $userDeals = app(GetDealsByUserIdTask::class)->run($row->user_id);
            $startedDeals = 0;
            $totalAmount = 0;
            $payments = 0;
            $deals = [];
            foreach ($userDeals as $dealData) {
                $receivedMoney[$dealData->id]['count'] = 0;
                $payment = 0;
                $startedDeals ++;
                $currencyTo = $request->selected_currency ?: $dealData->currency;
                $dealAmount = helpers\exchangeRate($dealData->currency, $currencyTo, $dealData->contract_amount, $rates);

                if (!$request->selected_currency) {
                    $totalAmount += helpers\exchangeRate($dealData->currency, Currency::getDescription(Currency::GBP), $dealData->contract_amount, $rates);
                } else {
                    $totalAmount += $dealAmount;
                }

                $paymentDatas = app(GetPaymentsByDealIdTask::class)->run($dealData->id);
                if ($paymentDatas->count()) {
                    foreach ($paymentDatas as $paymentData){
                        if ($paymentData->is_paid) {
                            $payment = helpers\exchangeRate($dealData->currency, $currencyTo, $paymentData->amount, $rates);
                            $receivedMoney[$dealData->id]['count']++;
                            if (!$request->selected_currency) {
                                $payments += helpers\exchangeRate($dealData->currency, Currency::getDescription(Currency::GBP), $paymentData->amount, $rates);
                            } else {
                                $payments += $payment;
                            }
                        }
                    }
                }

                if (!empty($dealData->payments_data)) {
                    $paymentData = date('Y-m-d', strtotime($dealData->payments_data[count($dealData->payments_data) - 1]['paymentDate']));
                } else {
                    $paymentData = '';
                }
                $lender = $dealData->offers->count() ? $dealData->offers->first()->user->first_name . ' ' . $dealData->offers->first()->user->last_name : '';
                $borrower = $dealData->user->first_name . ' ' . $dealData->user->last_name;

                $deals[] = [
                    'deal_id' => $this->encode($dealData->id),
                    'currency' => $currencyTo,
                    'contract_amount' => number_format($dealAmount,2),
                    'payment' => number_format($payment,2),
                    'outstanding' => number_format($dealAmount - $payment, 2),
                    'start_date' => $dealData->funding_date,
                    'finish_date' => $paymentData,
                    'status' => $dealData->status,
                    'borrower' => trim($borrower),
                    'lender' => trim($lender),
                    'counterparty' => [
                        'name' => app(GetCounterpartyNameTask::class)->run($dealData),
                        'avatar' => app(GetCounterpartyLogoTask::class)->run($dealData),
                    ],
                    'reason' => $dealData->reason,
                    'reason_label' => StatusReason::getDescription($dealData->reason),
                    "status_bar" => [
                        "percentaje" => app(GetDealProgressPercentageTask::class)->run($dealData),
                        "label" => StatusReason::getDescription($dealData->reason)
                    ],
                    'nb_installments' => $dealData->nb_installmetnts,
                    'paid_installments' => $receivedMoney[$dealData->id]['count'],
                    'is_past' => $dealData->nb_installmetnts === $receivedMoney[$dealData->id]['count'],
                ];
            }
            if ($borrowerModes[$row->user_id] == BorrowerType::CORPORATE) {
                $country = isset($profCountries[$row->user_id]) ? $profCountries[$row->user_id] : '';
            } else {
                $country = isset($addressCountries[$row->user_id]) ? $addressCountries[$row->user_id] : '';
            }

            $data[] = [
                'id' => $encode_id ? $this->encode($row->user_id) : $row->user_id,
                'name' => trim($user->first_name . ' ' . $user->last_name),
                'mode' => $borrowerModes[$row->user_id],
                'type' => $borrowerTypes[$row->value],
                'country' => $country,
                'sport' => isset($sports[$row->user_id]) ? $sports[$row->user_id] : '',
                'started_deals' => $startedDeals,
                'currency' => $request->selected_currency ?: Currency::getDescription(Currency::GBP),
                'contract_amount' => $totalAmount ? number_format($totalAmount,2) : 0,
                'outstanding' => number_format($totalAmount - $payments, 2),
                'deals' => $deals
            ];
        }

        return $data;
    }
}
