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
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Helpers as helpers;


class GetDealsPaymentsTask extends Task
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
        $res = $this->repository->select(
            'payments.deal_id',
            'deals.user_id',
            'deals.created_at',
            'deals.currency',
            'deals.contract_amount',
            'deals.nb_installmetnts',
            'users.first_name',
            'users.last_name',
            'payments.lender_id'
        )
            ->join('deals', 'payments.deal_id', '=',  'deals.id')
            ->when($isLender, function($query) use($user_id){
                return $query->where('payments.lender_id', $user_id);
            })
            ->join('users', 'users.id', '=', 'deals.user_id')
            ->where('deals.status', DealStatus::STARTED)
            ->groupBy('payments.deal_id', 'lender_id')
            ->get();

        $received = $this->repository->select('deal_id',\DB::raw('SUM(amount) as amount'), \DB::raw('COUNT(amount) as count'))
            ->where('is_paid', 1)->groupBy('deal_id')
            ->get();
        $receivedMoney = [];
        foreach($received as $row){
            $receivedMoney[$row->deal_id] = [
                'amount' => $row->amount,
                'count'  => $row->count
            ];
        }
        $data = [];
        $totalDealValue = 0;
        $totalPayments = 0;
        $rates = app(GetAllRatesTask::class)->run();
        foreach($res as $row) {
            $dealValue = helpers\exchangeRate($row->currency, $currencyTo, $row->contract_amount, $rates);
            $totalDealValue += $dealValue;
            $payment = isset($receivedMoney[$row->deal_id]) ? helpers\exchangeRate($row->currency, $currencyTo, $receivedMoney[$row->deal_id]['amount'], $rates) : 0;
            $totalPayments += $payment;
            $outstanding = isset($receivedMoney[$row->deal_id]) ? $dealValue - $payment : $dealValue;
            $borrowerType = $this->userProfileRepository->select('borrower_types.name')
                ->join('borrower_types','borrower_types.index','=','user_profiles.value')
                ->where('user_profiles.group',Group::ACCOUNT)
                ->where('user_profiles.key',Key::BORROWER_MODE_ID)->where('user_id', $row->user_id)->first()->name;
            $lenderName = '';
            $lenderType = '';
            if($row->lender_id != null) {
                $lender = app(FindUserByIdTask::class)->run($row->lender_id);
                $lenderName = trim($lender->first_name . ' ' . $lender->last_name);
                $lenderCriteria = $this->userProfileRepository->select('lender_criteria.value')
                    ->join('lender_criteria', 'lender_criteria.index', '=','user_profiles.value')
                    ->where('user_profiles.group',Group::ACCOUNT)
                    ->where('user_profiles.key',Key::LENDER_TYPE)
                    ->where('lender_criteria.type',Key::LENDER_TYPE)
                    ->where('user_profiles.user_id', $row->lender_id)
                    ->first();
                $lenderType = $lenderCriteria ? $lenderCriteria->value : '';
            }
            $data[]= [
                'date' => $row->created_at->format('Y-m-d'),
                'borrower' => trim($row->first_name . ' ' . $row->last_name),
                'borrower_type' => $borrowerType,
                'lender' => $lenderName,
                'lender_type' => $lenderType,
                'currency' => $currencyTo,
                'deal_value' => number_format($dealValue,2),
                'payments' => number_format($payment,2),
                'outstanding' => number_format($outstanding,2),
                'installments' => $row->nb_installmetnts,
                'paid_installments' => isset($receivedMoney[$row->deal_id]) ? $receivedMoney[$row->deal_id]['count'] : 0,
            ];
        }
        if ($data) {
            return [
                'data' => $data,
                'totalDealValue' => number_format($totalDealValue,2),
                'totalPayments' => number_format($totalPayments,2),
                'totalOutstanding' => number_format($totalDealValue - $totalPayments,2)
            ];
        } else {
            if ($isLender) {
                return [
                    'data' => [
                        [
                            'date' => "2021-12-13",
                            'borrower' => "Nume CinciDoi",
                            'borrower_type' => "Sports Lawyer",
                            'lender' => "First101 Last101",
                            'lender_type' => "Bank",
                            'currency' => $currencyTo,
                            'deal_value' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682427.46, $rates),
                            'payments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682.43, $rates),
                            'outstanding' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3678745.0, $rates),
                            'installments' => 5,
                            'paid_installments' => 1
                        ],
                        [
                            'date' => "2022-01-13",
                            'borrower' => "Nume CinciDoi",
                            'borrower_type' => "Sports Lawyer",
                            'lender' => "First101 Last101",
                            'lender_type' => "Bank",
                            'currency' => $currencyTo,
                            'deal_value' => helpers\exchangeRate(Currency::GBP, $currencyTo, 1472970.98, $rates),
                            'payments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682.43, $rates),
                            'outstanding' => helpers\exchangeRate(Currency::GBP, $currencyTo, 1469288.56, $rates),
                            'installments' => 5,
                            'paid_installments' => 2
                        ]
                    ],
                    'totalDealValue' => helpers\exchangeRate(Currency::GBP, $currencyTo, 5155398.44, $rates),
                    'totalPayments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 7364.85, $rates),
                    'totalOutstanding' => helpers\exchangeRate(Currency::GBP, $currencyTo, 5148033.58, $rates)
                ];
            } else {
                return [
                    'data' => [
                        [
                            'date' => "2021-12-13",
                            'borrower' => "Nume CinciDoi",
                            'borrower_type' => "Sports Lawyer",
                            'lender' => "First101 Last101",
                            'lender_type' => "Bank",
                            'currency' => $currencyTo,
                            'deal_value' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682427.46, $rates),
                            'payments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682.43, $rates),
                            'outstanding' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3678745.0, $rates),
                            'installments' => 5,
                            'paid_installments' => 1
                        ],
                        [
                            'date' => "2022-01-13",
                            'borrower' => "Nume CinciDoi",
                            'borrower_type' => "Sports Lawyer",
                            'lender' => "First101 Last101",
                            'lender_type' => "Bank",
                            'currency' => $currencyTo,
                            'deal_value' => helpers\exchangeRate(Currency::GBP, $currencyTo, 1472970.98, $rates),
                            'payments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 3682.43, $rates),
                            'outstanding' => helpers\exchangeRate(Currency::GBP, $currencyTo, 1469288.56, $rates),
                            'installments' => 5,
                            'paid_installments' => 2
                        ],
                        [
                            'date' => "2022-01-05",
                            'borrower' => "Nume CinciDoi",
                            'borrower_type' => "Sports Lawyer",
                            'lender' => "",
                            'lender_type' => "",
                            'currency' => $currencyTo,
                            'deal_value' => helpers\exchangeRate(Currency::GBP, $currencyTo, 1000000.00, $rates),
                            'payments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 5000.00, $rates),
                            'outstanding' => helpers\exchangeRate(Currency::GBP, $currencyTo, 995000.00, $rates),
                            'installments' => 4,
                            'paid_installments' => 1
                        ],
                    ],
                    'totalDealValue' => helpers\exchangeRate(Currency::GBP, $currencyTo, 6155398.44, $rates),
                    'totalPayments' => helpers\exchangeRate(Currency::GBP, $currencyTo, 12364.85, $rates),
                    'totalOutstanding' => helpers\exchangeRate(Currency::GBP, $currencyTo, 6143033.58, $rates)
                ];
            }
        }
    }
}
