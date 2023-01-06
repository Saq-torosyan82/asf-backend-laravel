<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\Deal\Enums\ContractType;
use App\Containers\AppSection\Deal\Enums\InstallmentFrequency;
use App\Containers\AppSection\System\Data\Repositories\LenderCriteriaRepository;
use App\Containers\AppSection\System\Enums\LenderCriteriaType;
use App\Ship\Parents\Tasks\Task;

class GetLenderCriteriaForDealTask extends Task
{
    protected LenderCriteriaRepository $repository;

    public function __construct(LenderCriteriaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($deal)
    {
        $res = $this->repository->select('ldc.id','ldc.lender_id', 'lc1.actual_value as min_amount', 'lc2.actual_value as max_amount', 'lc3.actual_value as min_tenor',
            'lc4.actual_value as max_tenor', 'lc5.value as interest_range', 'ldcc.country_id', 'lc6.value as currency','ldcs.sport_id', 'users.first_name', 'users.last_name')
            ->leftjoin('lender_deal_criteria as ldc','ldc.type','=','lender_criteria.id')
            ->leftjoin('lender_criteria as lc1','ldc.min_amount', '=', 'lc1.id')
            ->leftjoin('lender_criteria as lc2','ldc.max_amount', '=', 'lc2.id')
            ->leftjoin('lender_criteria as lc3','ldc.min_tenor', '=', 'lc3.id')
            ->leftjoin('lender_criteria as lc4','ldc.max_tenor', '=', 'lc4.id')
            ->leftjoin('lender_criteria as lc5','ldc.interest_range', '=', 'lc5.id')
            ->leftjoin('lender_deal_criterion_countries as ldcc','ldcc.criterion_id', '=', 'ldc.id')
            ->leftjoin('lender_deal_criterion_currencies as ldcc1','ldcc1.criterion_id', '=', 'ldc.id')
            ->leftjoin('lender_criteria as lc6','ldcc1.currency_id', '=', 'lc6.id')
            ->leftjoin('lender_deal_criterion_sports as ldcs','ldcs.criterion_id', '=', 'ldc.id')
            ->join('users','ldc.lender_id', '=', 'users.id')
            ->where('lender_criteria.type', LenderCriteriaType::DEAL_TYPE)
            ->where('lender_criteria.value', ContractType::getCriteriaDealType($deal->contract_type))
            ->where('ldcc.country_id', $deal->country_id)
            ->where('ldcs.sport_id', $deal->sport_id)
            ->where('lc6.value', strtolower($deal->currency))
            ->get();

        $result = [
            'lender_ids' => [],
            'lender_names' => []
        ];

        if ($res) {
            $tenor = InstallmentFrequency::getNumericValue($deal->frequency) * $deal->nb_installmetnts;
            foreach ($res as $row) {
                [$min_interest, $max_interest] = explode( '-', $row->interest_range);

                if ($deal->frequency == InstallmentFrequency::CUSTOM) {
                    $row->min_tenor = $row->max_tenor = 0;
                }

                if ($tenor >= $row->min_tenor && $tenor <= $row->max_tenor && $deal->interest_rate >= $min_interest
                    && $deal->interest_rate <= $max_interest && $deal->contract_amount >= $row->min_amount && $deal->contract_amount <= $row->max_amount) {
                    $first_name = isset($row->first_name) ? $row->first_name : '';
                    $last_name = isset($row->last_name) ? $row->last_name : '';
                    $result['lender_names'][] = trim($first_name . ' ' . $last_name);
                    $result['lender_ids'][] = $row->lender_id;
                }
            }
        }
        return $result;
    }
}
