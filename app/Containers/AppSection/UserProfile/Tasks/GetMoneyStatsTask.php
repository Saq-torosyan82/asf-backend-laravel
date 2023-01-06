<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\Deal\Enums\{
    DealType,
    StatusReason,
    DealStatus
};
use App\Containers\AppSection\Deal\Tasks\GetAllLenderDealsTask;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Containers\AppSection\System\Enums\Currency;
use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Helpers as helpers;

class GetMoneyStatsTask extends Task
{
    protected DealRepository $dealRepository;


    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function run($user_id, $isLender = false)
    {
        if ($isLender) {
            $res = app(GetAllLenderDealsTask::class)->run($user_id)->all();
        } else {
            $res = $this->dealRepository->select('id', 'status', 'currency', 'contract_amount')
                ->where('deal_type', '<>', DealType::FUTURE)
                ->where('reason', '<>', StatusReason::REJECTED_ASF)
                ->when(isset($user_id), function($query) use($user_id){
                    return $query->where('user_id', $user_id);
                })->get();
        }

        $groups = [
            'completed' => [
                'statuses' => [DealStatus::STARTED, DealStatus::COMPLETED],
                'amount' => 0
            ],
            'in_progress' => [
                'statuses' => [DealStatus::IN_PROGRESS, DealStatus::LIVE, DealStatus::ACCEPTED],
                'amount' => 0
            ],
            'not_started' => [
                'statuses' => [DealStatus::NOT_STARTED],
                'amount' => 0
            ],
        ];

        $data = [];
        $total = 0;
        $rates = app(GetAllRatesTask::class)->run();
        $currencyTo = Currency::getDescription(Currency::GBP);

        foreach ($res as $row) {
            $amountData = $isLender ? [
                'amount' => helpers\exchangeRate($row->deal->currency, $currencyTo, $row->deal->contract_amount, $rates),
                'status' => $row->deal->status,
            ] : [
                'amount' => helpers\exchangeRate($row->currency, $currencyTo,  $row->contract_amount, $rates),
                'status' => $row->status,
            ];
            if (in_array($row->status, $groups['completed']['statuses'])) {
                $groups['completed']['amount'] += $amountData['amount'];
            } elseif(in_array($row->status, $groups['in_progress']['statuses'])) {
                $groups['in_progress']['amount'] += $amountData['amount'];
            } else {
                $groups['not_started']['amount'] += $amountData['amount'];
            }
            $total += $amountData['amount'];
        }
        foreach ($groups as $key => $value) {
            $data[] = [
                'number' => $value['amount'],
                'key' => $key,
                'label' => ucfirst(str_replace('_',' ',$key))
            ];
        }

        return [
            'total' => is_float($total) ? number_format($total,2) : $total,
            'data' => $data
        ];
    }
}
