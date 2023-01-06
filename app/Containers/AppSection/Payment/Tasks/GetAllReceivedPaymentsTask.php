<?php

namespace App\Containers\AppSection\Payment\Tasks;

use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Containers\AppSection\Payment\Data\Repositories\PaymentRepository;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Containers\AppSection\System\Enums\Currency;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Carbon;
use App\Ship\Helpers as helpers;

class GetAllReceivedPaymentsTask extends Task
{
    protected PaymentRepository $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($user_id,$isLender = false)
    {
        $today = Carbon::now();
        $checkDate  = Carbon::now()->subRealWeeks(6);

        $data = [];
        $totalAmount = 0;
        $totalPayments = 0;
        $totalPaidInstallments = 0;
        $totalInstallments = 0;
        $countAll = 0;
        $weekPaymentsCount = 0;
        $rates = app(GetAllRatesTask::class)->run();
        $currencyTo = Currency::getDescription(Currency::GBP);
        $ids = [];

        $result = $this->repository->select('payments.amount', 'payments.deal_id','deals.currency', 'deals.id', 'deals.contract_amount', 'deals.nb_installmetnts', \DB::raw('DATE(payments.date) as payment_date'), 'payments.lender_id')
            ->where('payments.is_paid', 1)
            ->whereBetween(\DB::raw('DATE(payments.date)'), [new Carbon(strtotime($checkDate . ' -1 day')), $today])
            ->when($isLender, function($query) use($user_id){
                return $query->where('payments.lender_id', $user_id);
            })
            ->join('deals','deals.id','=','payments.deal_id')
            ->orderBy('payments.date')->get()->toArray();
        while ($checkDate->lte($today)) {
            ++$countAll;
            $checkDateToString = $checkDate->toDateString();
            $dateKeys = array_filter($result, function($element) use($checkDateToString){
                    return $element['payment_date'] == $checkDateToString;
                });
            if ($dateKeys) {
                $length = count($dateKeys);
                $weekPaymentsCount += $length;
                $totalPaidInstallments += $length;
                foreach ($dateKeys as $dateKey) {
                    if (!in_array($dateKey['id'], $ids)) {
                        $totalInstallments += $dateKey['nb_installmetnts'];
                        $totalAmount += helpers\exchangeRate($dateKey['currency'], $currencyTo, $dateKey['contract_amount'], $rates);
                        $ids[]= $dateKey['id'];
                    }
                    $totalPayments += helpers\exchangeRate($dateKey['currency'], $currencyTo, $dateKey['amount'], $rates);
                }
            }

            if ($countAll % 7 == 0 ) {
                $data[]= $weekPaymentsCount;
                $weekPaymentsCount = 0;
            }

            $checkDate = new Carbon(strtotime($checkDate . ' +1 day'));
        }
        $totalOutstanding = $totalAmount - $totalPayments;
        if ($result) {
            return [
                'total' => is_float($totalPayments) ? number_format($totalPayments,2) : $totalPayments,
                'totalInstallments' => $totalInstallments,
                'totalPaidInstallments' => $totalPaidInstallments,
                'totalOutstanding' => is_float($totalOutstanding) ? number_format($totalOutstanding, 2) : $totalOutstanding,
                'data' => $data
            ];
        } else {
            return [
                'total' => 38682.43,
                'totalInstallments' => 25,
                'totalPaidInstallments' => 13,
                'totalOutstanding' => 32478.00,
                'data' => [2, 5, 0, 1, 2, 3]
            ];
        }
    }
}
