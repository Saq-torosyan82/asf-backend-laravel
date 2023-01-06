<?php

namespace App\Containers\AppSection\Payment\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyLogoTask;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Containers\AppSection\System\Enums\Currency;
use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Helpers as helpers;


class GetPaymentsForBorrowerTask extends Task
{
    protected DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function run($userId)
    {
        $res = $this->dealRepository->select(
            'deals.id',
            'deals.currency',
            'deals.contract_amount',
            'deals.counterparty',
            'deals.nb_installmetnts',
            'deals.contract_type',
            'deals.criteria_data',
            'payments.is_paid',
            'payments.date',
            'payments.amount'
        )
            ->leftjoin('payments', 'payments.deal_id','=','deals.id')
            ->where('deals.user_id',$userId)
            ->where('deals.status', DealStatus::STARTED)
            ->get();
        $groups = [];
        $totalAmount = 0;
        $totalPayment = 0;
        $allInstallments = 0;
        $allPaidInstallments = 0;
        $rates = app(GetAllRatesTask::class)->run();
        $currencyTo = Currency::getDescription(Currency::GBP);
        $defaultLogo = LogoAssetType::getDetaultLogo(LogoAssetType::SPORT_CLUB);

        $ids = [];
        $labels = [];
        foreach($res as $row) {
            $key = $row->counterparty;
            $payment = $row->is_paid ? helpers\exchangeRate($row->currency, $currencyTo, $row->amount, $rates) : 0;
            $amount = 0;
            $numberPaidInstallments = $row->is_paid ? 1 : 0;

            if (in_array($row->id, $ids)) {
                $row->nb_installmetnts = 0;
            } else {
                $ids[]= $row->id;
                $amount = helpers\exchangeRate($row->currency, $currencyTo, $row->contract_amount, $rates);
            }

            if (!array_key_exists($key, $groups)) {
                $logo = app(GetCounterpartyLogoTask::class)->run($row);
                $labels[] = $logo != '' ? $logo : $defaultLogo;
                $groups[$key] = [
                    'label' => $row->counterparty,
                    'installments' => $row->nb_installmetnts,
                    'paid_installments' => $numberPaidInstallments
                ];
            } else {
                $groups[$key]['installments'] += $row->nb_installmetnts;
                $groups[$key]['paid_installments'] += $numberPaidInstallments;
            }

            $totalAmount += $amount;
            $allInstallments += $row->nb_installmetnts;
            $totalPayment += $payment;
            $allPaidInstallments += $numberPaidInstallments;
        }
        $columnCount = !empty($groups) ? count($groups) : 0;
        $colConfigCount = config('DashboardConfigs.borrower_payment_widget_columns_count');
        if($columnCount < $colConfigCount) {
            for($i = $columnCount; $i < $colConfigCount; $i++){
                array_push($labels, null);
                $groups[] = [
                    'label' => '',
                    'installments' => 0,
                    'paid_installments' => 0
                ];
            }
        }

        return [
            'data' => array_values($groups),
            'labels' => $labels,
            'totalAmount' => is_float($totalAmount) ? number_format($totalAmount,2) : $totalAmount,
            'totalPayment' =>  is_float($totalPayment) ? number_format($totalPayment,2) : $totalPayment,
            'allInstallments' => $allInstallments,
            'allPaidInstallments' => $allPaidInstallments
        ];
    }
}
