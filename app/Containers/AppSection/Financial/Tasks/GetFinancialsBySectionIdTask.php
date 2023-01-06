<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialDataRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FinancialItemRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FinancialSeasonRepository;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Ship\Helpers as helpers;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class GetFinancialsBySectionIdTask extends Task
{
    protected FinancialItemRepository $financialItemRepository;
    protected FinancialSeasonRepository $financialSeasonRepository;
    protected FinancialDataRepository $financialDataRepository;

    public function __construct(FinancialItemRepository $financialItemRepository, FinancialSeasonRepository $financialSeasonRepository, FinancialDataRepository $financialDataRepository)
    {
        $this->financialItemRepository = $financialItemRepository;
        $this->financialSeasonRepository = $financialSeasonRepository;
        $this->financialDataRepository = $financialDataRepository;
    }

    public function run($club_id, $section_id, $selected_currency, $limit = null)
    {
        $rates = app(GetAllRatesTask::class)->run();
        $labelsNotAmounts = ['average-attendance', 'unused-capacity', 'total-capacity', 'utilisation-rate'];
        $res = $this->financialItemRepository->select( 'financial_items.id as item_id',
            'financial_items.label as label',
            'financial_items.item_slag as item_slag',
            'financial_items.group_id as group_id',
            'financial_items.style as style',
            'financial_sections.label as sheet',
            'financial_sections.id as section_id'
        )
            ->join('financial_sections','financial_sections.id','=','financial_items.section_id')
            ->where('financial_items.section_id', $section_id)->get()->toArray();
        if (!$limit) {
            $limit = config('appSection-financial.seasons_count');
        }
        $seasons = $this->financialSeasonRepository->select('id','label')
            ->orderBy('index', 'DESC')
            ->limit($limit)
            ->get()->toArray();
        $seasonsCnt = count($seasons);
        for ($i = 0; $i < $seasonsCnt; $i++) {
            if (explode('/', $seasons[$i]['label'])[1] == date('y')) {
                $seasons[$i]['type'] = 'actual';
                $seasons[$i]['label'] = $seasons[$i]['label'] .' (' . $this->getQuarterOfYear() . 'm)';
            }
        }
        $itemsData = [];
        foreach ($res as $item) {
            if (!isset($itemsData[$item['group_id']])) {
                $itemsData[$item['group_id']] = [];
            }
            if (!isset($itemsData[$item['group_id']][$item['item_id']])) {
                $itemsData[$item['group_id']][$item['item_id']] = [
                    'label'  => $item['label'],
                    'item_slag' => $item['item_slag'],
                    'style'   => $item['style'],
                    'amounts' => []
                ];
            }
            foreach ($seasons as $season) {
                $itemAmount = $this->financialDataRepository->select('financials.season_id', 'financials.numbers_in', 'financial_data.amount', 'financials.currency')
                    ->leftJoin('financials', 'financial_data.financial_id', '=', 'financials.id')
                    ->where('financials.season_id', $season['id'])
                    ->where('financial_data.item_id', $item['item_id'])
                    ->where('financials.club_id', $club_id)->first();
                $amount = 0;
                if (!empty($itemAmount)) {
                    if (!in_array($item['item_slag'], $labelsNotAmounts)) {
                        $currencyTo = $selected_currency ?: $itemAmount->currency;
                        $amount = helpers\exchangeRate($itemAmount->currency, $currencyTo, $itemAmount->amount, $rates);
                    } else {
                        $amount = $itemAmount->amount;
                    }
                    $amount = round((float)str_replace(',', '', number_format($amount, 2)));
                }
                $itemsData[$item['group_id']][$item['item_id']]['amounts'][] = $amount;
            }
        }
        return [
            'items' => $itemsData,
            'seasons' => $seasons
        ];
    }
    private function getQuarterOfYear()
    {
        return  floor((Carbon::now()->month - 1) / 3) * 3 + 3;
    }
}
