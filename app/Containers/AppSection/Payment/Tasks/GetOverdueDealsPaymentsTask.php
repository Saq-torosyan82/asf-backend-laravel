<?php

namespace App\Containers\AppSection\Payment\Tasks;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Payment\Data\Repositories\PaymentRepository;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Containers\AppSection\System\Data\Repositories\BorrowerTypeRepository;
use App\Containers\AppSection\System\Data\Repositories\LenderCriteriaRepository;
use App\Containers\AppSection\System\Enums\Currency;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;
use App\Ship\Helpers as helpers;


class GetOverdueDealsPaymentsTask extends Task
{
    protected PaymentRepository $repository;
    protected LenderCriteriaRepository $criteriaRepository;
    protected UserProfileRepository $userProfileRepository;
    protected BorrowerTypeRepository $borrowerTypeRepository;

    public function __construct(PaymentRepository $repository, LenderCriteriaRepository $criteriaRepository,
                                UserProfileRepository $userProfileRepository, BorrowerTypeRepository $borrowerTypeRepository)
    {
        $this->criteriaRepository = $criteriaRepository;
        $this->repository = $repository;
        $this->userProfileRepository = $userProfileRepository;
        $this->borrowerTypeRepository = $borrowerTypeRepository;

    }

    public function run($user_id, $isLender = false, $currencyTo)
    {
        $dateNow = Carbon::now();
        $res = $this->repository->select(
            'payments.deal_id',
            'deals.user_id',
            'payments.date',
            'payments.amount',
            'payments.installment_nb',
            'deals.currency',
            'deals.nb_installmetnts',
            'deals.contract_amount',
            'users.first_name',
            'users.last_name',
            'payments.lender_id'
        )
            ->join('deals', 'payments.deal_id', '=',  'deals.id')
            ->when($isLender, function($query) use($user_id){
                  return $query->where('payments.lender_id', $user_id);
            })
            ->when(!$isLender, function($query) {
                return $query->leftJoin('deal_offers', 'payments.deal_id', '=',  'deal_offers.deal_id');
            })
            ->join('users', 'users.id', '=', 'deals.user_id')
            ->where('deals.status', DealStatus::STARTED)
            ->where('payments.date' , '<=', $dateNow)
            ->where('payments.is_paid', 0)
            ->get();

        $data = [];
        $totalDealValue = 0;
        $totalPayments = 0;
        $rates = app(GetAllRatesTask::class)->run();

        foreach($res as $row) {
            $dealValue = helpers\exchangeRate($row->currency,$currencyTo,$row->contract_amount,$rates);
            $totalDealValue += $dealValue;
            $payment = helpers\exchangeRate($row->currency,$currencyTo,$row->amount,$rates);
            $totalPayments += $payment;
            $date = new Carbon($row->date);
            $overdue = $date->diffInDays($dateNow);
            $lenderName = '';
            if($row->lender_id != null) {
                $lender = app(FindUserByIdTask::class)->run($row->lender_id);
                $lenderName = trim($lender->first_name . ' ' . $lender->last_name);
            }
            $data[]= [
                'date' => $date->toDateString(),
                'overdue' => $overdue,
                'borrower' => trim($row->first_name . ' ' . $row->last_name),
                'lender' => $lenderName,
                'currency' => $currencyTo,
                'deal_value' => number_format($dealValue,2),
                'payments' => number_format($payment,2),
                'installments' => $row->nb_installmetnts,
                'paid_installments' => $row->installment_nb
            ];
        }
        if($data) {
            return [
                'data' => $data,
                'totalDealValue' => number_format($totalDealValue,2),
                'totalPayments' => number_format($totalPayments,2)
            ];
        } else {
            if ($isLender){
                return [
                    'data' => [
                        [
                            'date' => "2022-02-02",
                            'overdue' => 11,
                            'borrower' => "Nume CinciDoi",
                            'lender' => "First101 Last101",
                            'currency' => $currencyTo,
                            'deal_value' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682427.46, $rates),
                            'payments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682.43, $rates),
                            'installments' => 5,
                            'paid_installments' => 3
                        ]
                    ],
                    'totalDealValue' =>  helpers\exchangeRate(Currency::GBP, $currencyTo, 3682427.46, $rates),
                    'totalPayments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682.43, $rates)
                ];
            } else {
                return [
                    'data' => [
                        [
                            'date' => "2022-02-02",
                            'overdue' => 11,
                            'borrower' => "Nume CinciDoi",
                            'lender' => "First101 Last101",
                            'currency' => $currencyTo,
                            'deal_value' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682427.46, $rates),
                            'payments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682.43, $rates),
                            'installments' => 5,
                            'paid_installments' => 3
                        ],
                        [
                            'date' => "2022-02-15",
                            'overdue' => 10,
                            'borrower' => "Nume CinciDoi",
                            'lender' => "",
                            'currency' => $currencyTo,
                            'deal_value' => helpers\exchangeRate(Currency::GBP, $currencyTo, 1000000.00, $rates),
                            'payments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 5000.00, $rates),
                            'installments' => 4,
                            'paid_installments' => 1
                        ],
                    ],
                    'totalDealValue' =>  helpers\exchangeRate(Currency::GBP, $currencyTo, 4682427.46, $rates),
                    'totalPayments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 8682.43, $rates)
                ];
            }
        }
    }
}
