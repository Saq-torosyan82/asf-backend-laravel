<?php

namespace App\Containers\AppSection\Financial\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use Carbon\Carbon;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Auth;
use App\Ship\Helpers as helpers;

use App\Containers\AppSection\Financial\Data\Repositories\{
    FinancialDataRepository,
    FinancialItemRepository,
    FinancialRepository,
    FinancialSeasonRepository
};
use App\Containers\AppSection\Financial\Enums\{
    FinancialDocumentsStatus,
    FinancialSectionsType
};
use App\Containers\AppSection\System\Enums\{
    Currency,
    LogoAssetType
};
use App\Containers\AppSection\System\Tasks\{FindSportClubByIdTask, FindCountryByIdTask, FindSportLeagueTask};
use App\Containers\AppSection\UserProfile\Enums\{Group, Key};

use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;

class GetUserFinancialsDataTask extends Task
{
    use HashIdTrait;
    protected FinancialRepository $repository;
    protected UserProfileRepository $userProfileRepository;
    protected FinancialSeasonRepository $financialSeasonRepository;
    protected FinancialItemRepository $financialItemRepository;
    protected FinancialDataRepository $financialDataRepository;

    public function __construct(FinancialRepository $repository,
                                FinancialSeasonRepository $financialSeasonRepository,
                                UserProfileRepository $userProfileRepository,
                                FinancialItemRepository $financialItemRepository,
                                FinancialDataRepository $financialDataRepository)
    {
        $this->repository = $repository;
        $this->userProfileRepository = $userProfileRepository;
        $this->financialSeasonRepository = $financialSeasonRepository;
        $this->financialItemRepository = $financialItemRepository;
        $this->financialDataRepository = $financialDataRepository;
    }

    public function run($user_id, $club_id, $limit = null, $selected_currency = null, $offset = 0, $forSnapshot = false)
    {
        $defaultCurrency = '';
        $numbersIn = '';
        $club = [];

        if (!$club_id) {
            if (Auth::user()->isCorporate()) {
                $club_id = $this->userProfileRepository->where('group', Group::PROFESSIONAL)
                    ->where('key', Key::CLUB)
                    ->where('user_id', $user_id)
                    ->first()->value;
            }
        }
        if ($club_id != null){
            $actualStatuses = app(GetSheetActualStatusTask::class)->run($user_id, $club_id);
            $positionsLeague = app(GetLeaguePositionTask::class)->run($club_id, $limit);

            // add club info
            $clubInfo = app(FindSportClubByIdTask::class)->run($club_id);
            if(!is_null($clubInfo)) {
                $club = [
                    'id'     => $this->encode($club_id),
                    'name'   => $clubInfo->name,
                    'logo'   => $this->getLogo(LogoAssetType::SPORT_CLUB, $clubInfo->logo),
                    'league' => [],
                ];
                $league = app(FindSportLeagueTask::class)->run(['id' => $clubInfo->league_id])->first();
                $club['league']['name'] = $league->name;
                $club['league']['logo'] = $this->getLogo(LogoAssetType::SPORT_LEAGUE, $league->logo);
                $countryInfo = app(FindCountryByIdTask::class)->run($clubInfo->country_id);
                $club['country'] = $countryInfo->name;
                $defaultCurrency = strtolower($countryInfo->name) == 'england' ? Currency::GBP : Currency::EUR;
            }
        }
        if (!$limit) {
            $limit = config('appSection-financial.seasons_count');
        }

        $seasons = $this->financialSeasonRepository->select('id','label')
            ->orderBy('index', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get()->toArray();

        $positions = [];
        $leagues = [];
        $seasonsCnt = count($seasons);
        for ($i = 0; $i < $seasonsCnt; $i++) {
            [$start, $end] = explode('/', $seasons[$i]['label']);
            $positions[] = isset($positionsLeague[$end]) ?  $positionsLeague[$end]['position'] : '';
            $leagues[] = isset($positionsLeague[$end]) ? $positionsLeague[$end]['league'] : '';
            if ($end == date('y')) {
                $seasons[$i]['type'] = 'actual';
                $seasons[$i]['label'] = $seasons[$i]['label'] .' (' . $this->getQuarterOfYear() . 'm)';
            }
        }
        $financialItems = $this->financialItemRepository->select(
            'financial_items.id as item_id',
            'financial_items.label as label',
            'financial_items.item_slag as item_slag',
            'financial_items.group_id as group_id',
            'financial_items.style as style',
            'financial_sections.label as sheet',
            'financial_sections.id as section_id'
        )
        ->join('financial_sections','financial_sections.id','=','financial_items.section_id')
            ->where('financial_sections.label', '<>', FinancialSectionsType::KEY_METRICS)
        ->get()->toArray();
        $rates = app(GetAllRatesTask::class)->run();
        $titleLabels = ['debtors', 'shareholder-loans', 'creditors', 'debt-structure', 'squad-valuation'];
        $itemsData   = [];
        $nonCurrentInterest = $nonCurrentNonInterest = $currentNonInterest = $currentInterest = $nonCurrentLoans = $currentLoans = $cashEquivalents = $nonPlayerCreditors = $curPlayerCreditors = $nonPlayerDebtors = $curPlayerDebtors = $deferredLiability = $taxContributions = $equity = $retainedEarnings = [];

        foreach ($financialItems as $item) {
            if (!isset($itemsData[$item['sheet']])) {
                $itemsData[$item['sheet']] = [
                    'id'     => $item['section_id'],
                    'status' => isset($actualStatuses[$item['sheet']]) ? $actualStatuses[$item['sheet']] : FinancialDocumentsStatus::getActualStatus(),
                    'items'  => [],
                ];
            }

            if (!isset($itemsData[$item['sheet']]['items'][$item['group_id']])) {
                $itemsData[$item['sheet']]['items'][$item['group_id']] = [];
            }

            if (!isset($itemsData[$item['sheet']]['items'][$item['group_id']][$item['item_id']])) {
                $itemsData[$item['sheet']]['items'][$item['group_id']][$item['item_id']] = [
                    'label'        => $item['label'],
                    'style'        => $item['style'],
                    'isEmpty'      => false,
                    'item_slag'    => $item['item_slag'],
                    'amounts'      => []
                ];
            }

            if (!in_array($item['item_slag'], $titleLabels)) {
                foreach ($seasons as $season) {
                    $itemAmount = $this->financialDataRepository->select('financials.season_id', 'financials.numbers_in', 'financial_data.amount', 'financials.currency')
                        ->leftJoin('financials', 'financial_data.financial_id', '=', 'financials.id')
                        ->where('financials.season_id', $season['id'])
                        ->where('financial_data.item_id', $item['item_id'])
                        ->where('financials.club_id', $club_id)->first();
                    $amountVal = $amount = 0;
                    if (!empty($itemAmount)) {
                        $numbersIn = isset($itemAmount->numbers_in) ? $itemAmount->numbers_in : '';
                        $currencyTo = $selected_currency ?: $itemAmount->currency;
                        $amount = helpers\exchangeRate($itemAmount->currency, $currencyTo, $itemAmount->amount, $rates);
                    }
                    if (!isset($season['type']) || $season['type'] != 'actual') {
                        $amountVal = $amount != 0 ? (float)str_replace(',', '', number_format($amount, 2)) : '-';
                    } else {
                        $amountVal = (float)str_replace(',', '', number_format($amount, 2));
                    }
                    $itemsData[$item['sheet']]['items'][$item['group_id']][$item['item_id']]['amounts'][] = $club_id == null ? '': $amountVal;
                    $itemsData[$item['sheet']]['items'][$item['group_id']][$item['item_id']]['currency'][] = isset($currencyTo) ? $currencyTo : Currency::GBP;

                    if ($club_id != null) {
                        switch ($item['item_slag']) {
                            case 'non-current-assets':
                                $groupIdNonCurrentAssets = $item['group_id'];
                                break;
                            case 'current-assets':
                                $groupIdCurrentAssets = $item['group_id'];
                                break;
                            case 'non-current-liabilities':
                                $groupIdNonCurrentLiabilities = $item['group_id'];
                                break;
                            case 'current-liabilities':
                                $groupIdCurrentLiabilities = $item['group_id'];
                                break;
                        }
                        $amountInGBP = isset($currencyTo) ? helpers\exchangeRate($currencyTo, Currency::GBP, $amount, $rates) : $amount;

                        switch ($item['item_slag']) {
                            case 'interest-bearing':
                                if ($item['group_id'] == $groupIdNonCurrentLiabilities) {
                                    $nonCurrentInterest[] = $amountInGBP;
                                } elseif ($item['group_id'] == $groupIdCurrentLiabilities) {
                                    $currentInterest[] = $amountInGBP;
                                }
                                break;
                            case 'non-interest-bearing':
                                if ($item['group_id'] == $groupIdNonCurrentLiabilities) {
                                    $nonCurrentNonInterest[] = $amountInGBP;
                                } elseif ($item['group_id'] == $groupIdCurrentLiabilities) {
                                    $currentNonInterest[] = $amountInGBP;
                                }
                                break;
                            case 'loans-and-borrowings':
                                if ($item['group_id'] == $groupIdNonCurrentLiabilities) {
                                    $nonCurrentLoans[] = $amountInGBP;
                                } elseif ($item['group_id'] == $groupIdCurrentLiabilities) {
                                    $currentLoans[] = $amountInGBP;
                                }
                                break;
                            case 'cash-and-cash-equivalents':
                                $cashEquivalents[] = $amountInGBP;
                                break;
                            case 'player-creditors':
                                if ($item['group_id'] == $groupIdNonCurrentLiabilities) {
                                    $nonPlayerCreditors[] = $amountInGBP;
                                } elseif ($item['group_id'] == $groupIdCurrentLiabilities) {
                                    $curPlayerCreditors[] = $amountInGBP;
                                }
                                break;
                            case 'player-debtors':
                                if ($item['group_id'] == $groupIdNonCurrentAssets) {
                                    $nonPlayerDebtors[] = $amountInGBP;
                                } elseif ($item['group_id'] == $groupIdCurrentAssets) {
                                    $curPlayerDebtors[] = $amountInGBP;
                                }
                                break;
                            case 'deferred-tax-liability':
                                if ($item['group_id'] == $groupIdNonCurrentLiabilities) {
                                    $deferredLiability[] = $amountInGBP;
                                }
                                break;
                            case 'tax-and-social-contributions':
                                if ($item['group_id'] == $groupIdNonCurrentLiabilities) {
                                    $taxContributions[] = $amountInGBP;
                                }
                                break;
                            case 'equity':
                                $equity[] = round($amountInGBP);
                                break;
                            case 'retained-earnings':
                                $retainedEarnings[] = round($amountInGBP);
                                break;
                        }
                    }
                }
            } else {
                $itemsData[$item['sheet']]['items'][$item['group_id']][$item['item_id']]['isEmpty'] = true;
            }
        }

        $returnData = [
            'seasons'         => $seasons,
            'items'           => $itemsData,
            'defaultCurrency' => $defaultCurrency,
            'numbers_in'      => $numbersIn,
            'club'            => $club,
            'currencies'      => Currency::getAllCurrencies()
        ];

        if ($club_id != null) {
            $returnData['items'] = $this->calculationForPL($returnData['items'], $seasonsCnt);
            $returnData['items'] = $this->calculationForBS($returnData['items'], $seasonsCnt, $nonCurrentInterest, $nonCurrentNonInterest, $nonCurrentLoans, $currentLoans, $currentInterest, $currentNonInterest, $cashEquivalents, $nonPlayerCreditors, $curPlayerCreditors, $nonPlayerDebtors, $curPlayerDebtors, $deferredLiability, $taxContributions, $equity, $retainedEarnings, $forSnapshot);

            $returnData = array_merge($returnData, [
                'positions'       => $positions,
                'leagues'         => $leagues,
                'defaultCurrency' => $defaultCurrency,
            ]);
        }

        return $returnData;
    }

    /**
     * @param $type
     * @param $logo
     * @return string
     */
    private function getLogo($type, $logo)
    {
        if ($logo) {
            return route(
                'web_system_logo_asset',
                [LogoAssetType::getLogoPath($type), $logo]
            );
        }

        return LogoAssetType::getDetaultLogo($type);
    }

    /**
     * @param $itemsData
     * @param $seasonsCnt
     * @return array
     */
    private function calculationForPL($itemsData, $seasonsCnt) {
        if (!empty($itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]) && !empty($itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['items']) && Auth::user()->isAdmin()) {
            $itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['Revenue_Breakup_%'] = [
                'label' => 'Revenue Breakup (%)',
                'items' => []
            ];
            $itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['EBIT_margin_%'] = [];

            $totalRevenueAmounts= [];
            $broadcastingCalculated = $commercialCalculated = $matchdayCalculated = $staffCostsCalculated = $ebitCalculated = false;

            foreach ($itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['items'] as $items) {
                if (empty($totalRevenueAmounts) || !$broadcastingCalculated || !$commercialCalculated || !$matchdayCalculated || !$staffCostsCalculated || !$ebitCalculated) {
                    $items = array_values($items);

                    // Get total amounts
                    if (empty($totalRevenueAmounts)) {
                        $key = array_search('total-operating-revenue', array_column($items, 'item_slag'));
                        if ($key !== false) {
                            foreach ($items[$key]['amounts'] as $amount) {
                                $totalRevenueAmounts[] = $amount == '-' ? 0 : $amount;
                            }
                        }
                    }

                    if (!$broadcastingCalculated) {
                        $key = array_search('broadcasting', array_column($items, 'item_slag'));
                        if ($key !== false) {
                            $percents = [];
                            for ($i = 0; $i < $seasonsCnt; ++$i) {
                                $items[$key]['amounts'][$i] = $items[$key]['amounts'][$i] != '-' ? : 0;
                                $percentVal = ($items[$key]['amounts'][$i] == 0 || $totalRevenueAmounts[$i] == 0) ? 0 : round($items[$key]['amounts'][$i] / $totalRevenueAmounts[$i] * 100);
                                array_push($percents, $percentVal . '%');
                            }

                            $itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['Revenue_Breakup_%']['items'][] = [
                                'label' => $items[$key]['label'],
                                'values' => $percents
                            ];
                            $broadcastingCalculated = true;
                        }
                    }

                    if (!$commercialCalculated) {
                        $key = array_search('commercial', array_column($items, 'item_slag'));
                        if ($key !== false) {
                            $percents = [];
                            for ($i = 0; $i < $seasonsCnt; ++$i) {
                                $items[$key]['amounts'][$i] = $items[$key]['amounts'][$i] != '-' ? : 0;
                                $percentVal = ($items[$key]['amounts'][$i] == 0 || $totalRevenueAmounts[$i] == 0) ? 0 : round($items[$key]['amounts'][$i] / $totalRevenueAmounts[$i] * 100);
                                array_push($percents, $percentVal . '%');
                            }
                            $itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['Revenue_Breakup_%']['items'][] = [
                                'label' => $items[$key]['label'],
                                'values' => $percents
                            ];
                            $commercialCalculated = true;
                        }
                    }

                    if (!$matchdayCalculated) {
                        $key = array_search('matchday', array_column($items, 'item_slag'));
                        if ($key !== false) {
                            $percents = [];
                            for ($i = 0; $i < $seasonsCnt; ++$i) {
                                $items[$key]['amounts'][$i] = $items[$key]['amounts'][$i] != '-' ? : 0;
                                $percentVal = ($items[$key]['amounts'][$i] == 0 || $totalRevenueAmounts[$i] == 0) ? 0 : round($items[$key]['amounts'][$i] / $totalRevenueAmounts[$i] * 100);
                                array_push($percents, $percentVal . '%');
                            }
                            $itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['Revenue_Breakup_%']['items'][] = [
                                'label' => $items[$key]['label'],
                                'values' => $percents
                            ];
                            $matchdayCalculated = true;
                        }
                    }

                    if (!$staffCostsCalculated) {
                        $key = array_search('staff-costs', array_column($items, 'item_slag'));
                        if ($key !== false) {
                            $percents = [];
                            for ($i = 0; $i < $seasonsCnt; ++$i) {
                                $items[$key]['amounts'][$i] = $items[$key]['amounts'][$i] == '-' ? 0 : $items[$key]['amounts'][$i] * -1;
                                $percentVal = ($items[$key]['amounts'][$i] == 0 || $totalRevenueAmounts[$i] == 0) ? 0 : round($items[$key]['amounts'][$i] / $totalRevenueAmounts[$i] * 100);
                                array_push($percents, $percentVal . '%');
                            }
                            $itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['Revenue_Breakup_%']['items'][] = [
                                'label' => $items[$key]['label'],
                                'values' => $items[$key]['amounts']
                            ];
                            $itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['Revenue_Breakup_%']['items'][] = [
                                'label' => '  Staff cost to revenues(%)',
                                'values' => $percents
                            ];
                            $staffCostsCalculated = true;
                        }
                    }

                    if (!$ebitCalculated) {
                        $key = array_search('earnings-before-interest-and-tax-ebit', array_column($items, 'item_slag'));
                        if ($key !== false) {
                            $percents = [];
                            for ($i = 0; $i < $seasonsCnt; ++$i) {
                                $items[$key]['amounts'][$i] = $items[$key]['amounts'][$i] != '-' ? : 0;
                                $percentVal = ($items[$key]['amounts'][$i] == 0 || $totalRevenueAmounts[$i] == 0) ? 0 : round($items[$key]['amounts'][$i] / $totalRevenueAmounts[$i] * 100);
                                array_push($percents, $percentVal . '%');
                            }
                            $itemsData[FinancialSectionsType::PROFIT_LOSS_SHEET]['EBIT_margin_%'][] = [
                                'label' => "EBIT margin (%)",
                                'style' => 'bold',
                                'values' => $percents
                            ];
                            $ebitCalculated = true;
                        }
                    }
                } else {
                    break;
                }
            }
        }
        return $itemsData;
    }

    private function calculationForBS($itemsData, $seasonsCnt, $nonCurrentInterest, $nonCurrentNonInterest, $nonCurrentLoans, $currentLoans,
                                      $currentInterest, $currentNonInterest, $cashEquivalents, $nonPlayerCreditors, $curPlayerCreditors, $nonPlayerDebtors, $curPlayerDebtors, $deferredLiability, $taxContributions, $equity, $retainedEarnings, $forSnapshot)
    {
        if (!empty($nonCurrentInterest) && !empty($nonCurrentNonInterest) && !empty($nonCurrentLoans) && !empty($currentLoans)
            && !empty($currentInterest) && !empty($currentNonInterest) && !empty($cashEquivalents) && !empty($nonPlayerCreditors) && !empty($curPlayerCreditors) && !empty($nonPlayerDebtors) && !empty($curPlayerDebtors) && !empty($deferredLiability) && !empty($taxContributions) && !empty($equity) && !empty($retainedEarnings)) {
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile'] = [
                'label' => 'Debt Profile',
                'items' => []
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Shareholder_support'] = [
                'label' => 'Shareholder support:',
                'items' => []
            ];

            $financialDebts = $transferDebts = $socialDues = $totalNetDebt = [];
            $shareholderDebt = $otherDebt = $cash = $playerCreditors = $playerDebtors = [];
            $equityShareholderDebt = $invisible = [];
            for ($i = 0; $i < $seasonsCnt; ++$i) {
                $finDebt = $nonCurrentInterest[$i] + $nonCurrentNonInterest[$i] + $nonCurrentLoans[$i] + $currentLoans[$i] + $currentInterest[$i] + $currentNonInterest[$i] - $cashEquivalents[$i];
                $finDebt = $finDebt < 0 && !$forSnapshot ? 0 : $finDebt;
                $financialDebts[] = $forSnapshot ? (float)number_format($finDebt) : round($finDebt);

                $transferDebt = ($nonPlayerCreditors[$i] + $curPlayerCreditors[$i]) - ($nonPlayerDebtors[$i] + $curPlayerDebtors[$i]);
                $transferDebts[] = $forSnapshot ? (float)number_format(($transferDebt * (-1)),2) : round($transferDebt);

                $socialDue = $deferredLiability[$i] + $taxContributions[$i];
                $socialDues[] = round($socialDue);

                $sum = $forSnapshot ? ($finDebt + $transferDebt) : ($finDebt + $transferDebt + $socialDue);
                $totalNetDebt[] = $forSnapshot ? (float)number_format($sum, 2)  : round($sum);
                $sum = $nonCurrentInterest[$i] + $nonCurrentNonInterest[$i] + $currentInterest[$i] + $currentNonInterest[$i];
                $shareholderDebt[] = $forSnapshot ? (float)number_format($sum, 2) : round($sum);
                $sum = $nonCurrentLoans[$i] + $currentLoans[$i];
                $otherDebt[] = $forSnapshot ? (float)number_format($sum, 2) : round($sum);
                $cash[] = round($cashEquivalents[$i]);
                $sum = $nonPlayerCreditors[$i] + $curPlayerCreditors[$i];
                $playerCreditors[] = $forSnapshot ? (float)number_format($sum, 2) : round($sum);
                $sum = $nonPlayerDebtors[$i] + $curPlayerDebtors[$i];
                $playerDebtors[] = $forSnapshot ? (float)number_format($sum, 2) : round($sum);
                $equityShareholderDebt[] = round($shareholderDebt[$i] + $equity[$i]);
                $shareCapitalReserves[] = $equity[$i] - $retainedEarnings[$i];
            }
            $maxValue = max(array_merge($shareholderDebt, $otherDebt, $cash));
            for ($i = 0; $i < $seasonsCnt; ++$i) {
                $invisible[] = $maxValue;
            }
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Net financial debt',
                'values' => $financialDebts
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Net transfer debt',
                'values' => $transferDebts
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Social/tax dues (non-current)',
                'values' => $socialDues
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Total net debt',
                'values' => $totalNetDebt
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Shareholder debt',
                'values' => $shareholderDebt
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Other debt',
                'values' => $otherDebt
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Cash',
                'values' => $cash
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Invisible LHS',
                'values' => $invisible
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Invisible RHS',
                'values' => $invisible
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Player creditors',
                'values' => $playerCreditors
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'][] =[
                'label' => 'Player debtors',
                'values' => $playerDebtors
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Shareholder_support']['items'][] =[
                'label' => 'Retained Earnings',
                'values' => $retainedEarnings
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Shareholder_support']['items'][] =[
                'label' => 'Equity',
                'values' => $equity
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Shareholder_support']['items'][] =[
                'label' => 'Shareholder debt',
                'values' => $shareholderDebt
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Shareholder_support']['items'][] =[
                'label' => 'Equity + Shareholder Debt',
                'values' => $equityShareholderDebt
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Shareholder_support']['items'][] =[
                'label' => 'Base',
                'values' => $retainedEarnings
            ];
            $itemsData[FinancialSectionsType::BALANCE_SHEET]['Shareholder_support']['items'][] =[
                'label' => 'Share capital + reserves',
                'values' => $shareCapitalReserves
            ];
        }
        return $itemsData;
    }

    private function getQuarterOfYear()
    {
        return  floor((Carbon::now()->month - 1) / 3) * 3 + 3;
    }
}
