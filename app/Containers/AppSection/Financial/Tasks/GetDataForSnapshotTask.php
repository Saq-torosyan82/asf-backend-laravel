<?php

namespace App\Containers\AppSection\Financial\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Financial\Data\Repositories\FactIntervalRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FactNameRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FinancialDataRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FinancialItemRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FinancialSeasonRepository;
use App\Containers\AppSection\Financial\Enums\FactSectionsType;
use App\Containers\AppSection\Financial\Enums\FinancialSectionsType;
use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\GetFollowersForSnapshotTask;
use App\Containers\AppSection\UserSponsorship\Tasks\GetSponsorsForSnapshotTask;
use App\Ship\Parents\Tasks\Task;

class GetDataForSnapshotTask extends Task
{
    use HashIdTrait;
    protected UserProfileRepository $userProfileRepository;
    protected FactIntervalRepository $factIntervalRepository;
    protected FactNameRepository $factNameRepository;
    protected FinancialSeasonRepository $financialSeasonRepository;
    protected FinancialItemRepository $financialItemRepository;
    protected FinancialDataRepository $financialDataRepository;

    public function __construct(UserProfileRepository     $userProfileRepository,
                                FactIntervalRepository    $factIntervalRepository,
                                FactNameRepository        $factNameRepository,
                                FinancialSeasonRepository $financialSeasonRepository,
                                FinancialItemRepository   $financialItemRepository,
                                FinancialDataRepository   $financialDataRepository)
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->factIntervalRepository = $factIntervalRepository;
        $this->factNameRepository = $factNameRepository;
        $this->financialSeasonRepository = $financialSeasonRepository;
        $this->financialItemRepository = $financialItemRepository;
        $this->financialDataRepository = $financialDataRepository;
    }

    public function run($club_id, $user_id, $selected_currency)
    {
        if (!$club_id) {
            $club_id = $this->userProfileRepository->where('group', Group::PROFESSIONAL)
                ->where('key', Key::CLUB)
                ->where('user_id', $user_id)->first()->value;
        } elseif (!$user_id) {
            $user_id = $this->userProfileRepository->where('group', Group::PROFESSIONAL)
                ->where('key', Key::CLUB)
                ->where('value', $club_id)->first()->user_id;
        }
        $seasonsLimit = config('appSection-financial.seasons_count_snapshot_value_part');
        $res = app(GetFactsBySectionIdTask::class)->run($club_id, null, true);
        $labels = ['Official club name' => 'Company', 'Owner(s)' => 'Owners', 'Address' => 'Address', 'Website' => 'Website'];
        $infos = [];
        foreach ($labels as $label => $value) {
            $key = array_search($label, array_column($res, 'name'));
            $infos[] = [
                'label' => $value,
                'value' => $key !== false ? $res[$key]['value'] : ''
            ];
        }
        $labels = ['Manager' => ['label'=>'Manager', 'style'=>'bold'],  'Squad size' => ['label' => 'Squad Size', 'style' => ''], 'Squad value' => ['label' => 'Squad Value*  (as per Transfermarkt)', 'style' => ''], 'Stadium Name' => ['label' => 'Ground', 'style' => 'bold'], 'Capacity' => ['label' => 'Capacity', 'style' => 'bold']];
        $infoSquad = [];
        foreach ($labels as $label => $value) {
            $key = array_search($label, array_column($res, 'name'));
            $infoSquad[] = [
                'label' => $value['label'],
                'style' => $value['style'],
                'value' => $key !== false ? $res[$key]['value'] : ''
            ];
        }
        $intervalsData = $this->factIntervalRepository->select('id', 'interval')
            ->orderBy('index', 'DESC')
            ->limit(config('appSection-financial.seasons_count_snapshot_club_part'))
            ->get()->toArray();
        $intervalIds = [];
        $intervals = [];
        if (explode('/', $intervalsData[0]['interval'])[1] == date('y')) {
            array_shift($intervalsData);
        } else {
            array_pop($intervalsData);
        }
        foreach ($intervalsData as $interval) {
            $intervalIds[] = $interval['id'];
            $intervals[] = explode('/', $interval['interval'])[0];
        }
        $slugs = ['broadcasting' => 'Broadcasting Revenue', 'commercial' => 'Commercial Revenue', 'matchday' => 'Matchday Revenue',   'total-operating-revenue' => 'Total Revenue', 'staff-costs' => 'Staff Wages', 'operating-profit-loss' => 'Operating Profits', 'profit-loss-on-player-sales' => 'Profit on Player Sales', 'earnings-before-interest-and-tax-ebit' => 'EBITDA', 'profit-loss-after-tax' => 'Net Profit'];

        $debtLabels = ['Shareholder Debt' => 'Shareholder debt', 'External Debt' => 'Other debt', 'Net Transfer Debt' => 'Net transfer debt',
            'Net Total Debt* (as defined by UEFA)' => 'Total net debt', 'Transfer Debt Payable' => 'Player creditors', 'Transfer Debt Receivable' => 'Player debtors'];

        $transferLabels = ['Player creditors', 'Player debtors'];
        $incomeStatementData = [
            'label' => 'Income Statement',
            'items' => []
        ];
        $balanceSheetData = [
            'label' => 'Balance Sheet',
            'items' => []
        ];
        $playerTransferData = [
            'label' => 'Player Transfers',
            'items' => []
        ];
        $averageData = [
            'label' => 'Stadium Average Attendance',
            'items' => []
        ];
        $total = $amortisation = [];
        $keyMetrics = app(GetFinancialsBySectionIdTask::class)->run($club_id, FinancialSectionsType::getId(FinancialSectionsType::KEY_METRICS), $selected_currency);
        $isActual = explode(' (', explode( '/',$keyMetrics['seasons'][0]['label'])[1])[0] == date('y');
        if (!empty($keyMetrics) && !empty($keyMetrics['items'])) {
            $averageData['seasons'] = $keyMetrics['seasons'];
            $playerSale = $playerPurchases = $averageAttendance = $utilisationRate = false;
            foreach ($keyMetrics['items'] as $metricsItems) {
                if (!$playerSale || !$playerPurchases || !$averageAttendance || !$utilisationRate) {
                    $metricsItems = array_values($metricsItems);
                    if (!$playerSale) {
                        $key = array_search('sales', array_column($metricsItems, 'item_slag'));
                        if ($key !== false) {
                            array_shift($metricsItems[$key]['amounts']);
                            if ($isActual) {
                                array_pop($metricsItems[$key]['amounts']);
                            }
                            $playerTransferData['items'][] = [
                                'label'   => 'Player Sales',
                                'amounts' => $metricsItems[$key]['amounts']
                            ];
                            $playerSale = true;
                        }
                    }
                    if (!$playerPurchases) {
                        $key = array_search('acquisitions', array_column($metricsItems, 'item_slag'));
                        if ($key !== false) {
                            array_shift($metricsItems[$key]['amounts']);
                            if ($isActual) {
                                array_pop($metricsItems[$key]['amounts']);
                            }
                            $playerTransferData['items'][] = [
                                'label'   => 'Player Purchases',
                                'amounts' => $metricsItems[$key]['amounts']
                            ];
                            $playerPurchases = true;
                        }
                    }
                    if (!$averageAttendance) {
                        $key = array_search('average-attendance', array_column($metricsItems, 'item_slag'));
                        if ($key !== false) {
                            $averageData['items'][] = [
                                'label'   => $metricsItems[$key]['label'],
                                'amounts' => $metricsItems[$key]['amounts']
                            ];
                            $averageAttendance = true;
                        }
                    }
                    if (!$utilisationRate) {
                        $key = array_search('total-capacity', array_column($metricsItems, 'item_slag'));
                        if ($key !== false) {
                            $averageData['items'][] = [
                                'label'   => $metricsItems[$key]['label'],
                                'amounts' => $metricsItems[$key]['amounts']
                            ];
                            $utilisationRate = true;
                        }
                    }
                } else {
                    break;
                }
            }
        }
        $items = app(GetUserFinancialsDataTask::class)->run($user_id, $club_id, $seasonsLimit, $selected_currency, 0,true);
        if (!empty($items) && !empty($items['items'])) {
            $club = $items['club'];
            if ($isActual) {
                $indexOne = 1;
                $indexTwo = 2;
            } else {
                $indexOne = 0;
                $indexTwo = 1;
            }
            if (!empty($items['items'][FinancialSectionsType::CASH_FLOW]) && !empty($items['items'][FinancialSectionsType::CASH_FLOW]['items'])) {
                $amortisationCalculated = false;
                foreach ($items['items'][FinancialSectionsType::CASH_FLOW]['items'] as $cashItems) {
                    if (!$amortisationCalculated) {
                        $cashItems = array_values($cashItems);
                        $key = array_search('amortisation-depreciation', array_column($cashItems, 'item_slag'));
                        if ($key !== false) {
                            $amortisation = $cashItems[$key]['amounts'];
                            $amortisationCalculated = true;
                        }
                    }
                }
            }
            if (!empty($items['items'][FinancialSectionsType::PROFIT_LOSS_SHEET]) && !empty($items['items'][FinancialSectionsType::PROFIT_LOSS_SHEET]['items'])) {
                foreach ($items['items'][FinancialSectionsType::PROFIT_LOSS_SHEET]['items'] as $resultByGroup) {
                    foreach ($resultByGroup as $result) {
                        if (array_key_exists($result['item_slag'], $slugs)) {
                            if ($result['item_slag'] == 'total-operating-revenue') {
                                $total = $result['amounts'];
                            } elseif ($result['item_slag'] == 'staff-costs') {
                                $revenueWages = [];
                                $revenueWagesPercents = [];
                                for ($i = 0; $i < $seasonsLimit; ++$i) {
                                    $result['amounts'][$i] = $result['amounts'][$i] == '-' ? 0 : $result['amounts'][$i] * -1;
                                    $percentVal = ($result['amounts'][$i] == 0 || $total[$i] == 0) ? 0 : round($result['amounts'][$i] / $total[$i] * 100);
                                    $revenueWages[] = $percentVal;
                                    $revenueWagesPercents[] = $percentVal . '%';
                                }
                                $numberOne = $revenueWages[$indexTwo] == '-' ? 0 : $revenueWages[$indexTwo];
                                $numberTwo = $revenueWages[$indexOne] == '-' ? 0 : $revenueWages[$indexOne];
                                $growth = $this->calculateGrowth($numberOne, $numberTwo);
                                $incomeStatementData['items'][] = [
                                    'label' => 'Wages to Turnover',
                                    'amounts' => $revenueWagesPercents,
                                    'growth' => round($growth) . '%'
                                ];
                            } elseif ($result['item_slag'] == 'earnings-before-interest-and-tax-ebit') {
                                for ($i = 0; $i < $seasonsLimit; ++$i) {
                                    $result['amounts'][$i] = $result['amounts'][$i] == '-' ? 0 : $result['amounts'][$i];
                                    $amortisation[$i] = $amortisation[$i] == '-' ? 0 : $amortisation[$i];
                                    $result['amounts'][$i] = $result['amounts'][$i] == '-' ? $amortisation[$i] : (float)number_format($result['amounts'][$i] + $amortisation[$i], 2);
                                }
                            }
                            $numberOne = $result['amounts'][$indexTwo] == '-' ? 0 : $result['amounts'][$indexTwo];
                            $numberTwo = $result['amounts'][$indexOne] == '-' ? 0 : $result['amounts'][$indexOne];

                            $growth = $this->calculateGrowth($numberOne, $numberTwo);
                            $incomeStatementData['items'][] = [
                                'label' => $slugs[$result['item_slag']],
                                'amounts' => $result['amounts'],
                                'growth' => round($growth) . '%'
                            ];
                        }
                    }
                }
            }
            if (!empty($items['items'][FinancialSectionsType::BALANCE_SHEET]) && !empty($items['items'][FinancialSectionsType::BALANCE_SHEET]['items'])) {
                $totalAssets = $playerRegistration = $equity = false;
                foreach ($items['items'][FinancialSectionsType::BALANCE_SHEET]['items'] as $balanceItems) {
                    if (!$totalAssets || !$playerRegistration || !$equity) {
                        $balanceItems = array_values($balanceItems);
                        if (!$totalAssets) {
                            $key = array_search('total-assets', array_column($balanceItems, 'item_slag'));
                            if ($key !== false) {
                                $numberOne = $balanceItems[$key]['amounts'][$indexTwo] == '-' ? 0 : $balanceItems[$key]['amounts'][$indexTwo];
                                $numberTwo = $balanceItems[$key]['amounts'][$indexOne] == '-' ? 0 : $balanceItems[$key]['amounts'][$indexOne];

                                $growth = $this->calculateGrowth($numberOne, $numberTwo);
                                $balanceSheetData['items'][] = [
                                    'label'   => trim($balanceItems[$key]['label'],':'),
                                    'amounts' => $balanceItems[$key]['amounts'],
                                    'growth'    => round($growth) . '%'
                                ];
                                $totalAssets = true;
                            }
                        }
                        if (!$playerRegistration) {
                            $key = array_search('players-registrations', array_column($balanceItems, 'item_slag'));
                            if ($key !== false) {
                                $numberOne = $balanceItems[$key]['amounts'][$indexTwo] == '-' ? 0 : $balanceItems[$key]['amounts'][$indexTwo];
                                $numberTwo = $balanceItems[$key]['amounts'][$indexOne] == '-' ? 0 : $balanceItems[$key]['amounts'][$indexOne];

                                $growth = $this->calculateGrowth($numberOne, $numberTwo);
                                $balanceSheetData['items'][] = [
                                    'label'   => ucwords(str_replace("'","", $balanceItems[$key]['label'])),
                                    'amounts' => $balanceItems[$key]['amounts'],
                                    'growth'  => round($growth) . '%'
                                ];
                                $playerRegistration = true;
                            }
                        }
                        if (!$equity) {
                            $key = array_search('equity', array_column($balanceItems, 'item_slag'));
                            if ($key !== false) {
                                $numberOne = $balanceItems[$key]['amounts'][$indexTwo] == '-' ? 0 : $balanceItems[$key]['amounts'][$indexTwo];
                                $numberTwo = $balanceItems[$key]['amounts'][$indexOne] == '-' ? 0 : $balanceItems[$key]['amounts'][$indexOne];

                                $growth = $this->calculateGrowth($numberOne, $numberTwo);
                                $balanceSheetData['items'][] = [
                                    'label'   => $balanceItems[$key]['label'],
                                    'amounts' => $balanceItems[$key]['amounts'],
                                    'growth'  => round($growth) . '%'
                                ];
                                $equity = true;
                            }
                        }
                    } else {
                        break;
                    }
                }
                if (!empty($items['items'][FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']) && !empty($items['items'][FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'])) {
                    $debtResult = $items['items'][FinancialSectionsType::BALANCE_SHEET]['Debt_Profile']['items'];
                    foreach ($debtLabels as $key => $value) {
                        $index = array_search($value, array_column($debtResult, 'label'));
                        $item = [
                            'label'   => $key,
                            'amounts' => [],
                        ];
                        $isTransfer = in_array($value, $transferLabels);
                        if ($index !== false) {
                            if ($isTransfer) {
                                array_shift($debtResult[$index]['values']);
                            } else {
                                $numberOne = $debtResult[$index]['values'][$indexTwo] == '-' ? 0 : $debtResult[$index]['values'][$indexTwo];
                                $numberTwo = $debtResult[$index]['values'][$indexOne] == '-' ? 0 : $debtResult[$index]['values'][$indexOne];
                                $growth = $this->calculateGrowth($numberOne, $numberTwo);
                                $item['growth']  = round($growth) . '%';
                            }
                            $item['amounts'] = $debtResult[$index]['values'];
                        } else {
                            for ($i = 0; $i < $seasonsLimit; ++$i) {
                                $item['amounts'][] = '-';
                            }
                        }
                        if ($isTransfer) {
                            $playerTransferData['items'][] = $item;
                        } else {
                            $balanceSheetData['items'][] = $item;
                        }
                    }
                }
            }
        }

        $result = app(GetFactsWithIntervalsBySectionIdTask::class)->run($club_id,  FactSectionsType::getId(FactSectionsType::COMPETITION_POSITION_FINISH), $intervalIds);
        $labels = [
            ['key' => 'League', 'label' => $club['league']['name'], 'country' => 'all'],
            ['key' => 'FA Cup', 'label' => 'FA Cup', 'country' => 'England'],
            ['key' => 'EFL Cup', 'label' => 'EFL Cup', 'country' => 'England'],
            ['key' => 'DFB-Pokal', 'label' => 'DFB-Pokal', 'country' => 'Germany'],
            ['key' => 'DFB Pokal', 'label' => 'DFB Pokal', 'country' => 'Germany'],
            ['key' => 'Coppa Italia', 'label' => 'Coppa Italia', 'country' => 'Italy'],
            ['key' => 'Copa Del Rey', 'label' => 'Copa Del Rey', 'country' => 'Spain'],
            ['key' => 'Coupe de France', 'label' => 'Coupe de France', 'country' => 'France'],
            ['key' => 'Champions League', 'label' => 'UEFA Championships League', 'country' => 'all'],
            ['key' => 'Europa League', 'label' => 'UEFA Europa Club', 'country' => 'all'],
            ['key' => 'Europa Conference', 'label' => 'UEFA Conference League', 'country' => 'all'],
        ];
        $forCheck = ['country' => 'Germany', 'key' => 'DFB-Pokal'];
        $leagues = [];
        foreach ($labels as $index => $value) {
            $positions = [];
            $label = $value['key'];
            $keys = array_filter($result, function($element) use($label){
                return $element['label'] == $label;
            });
            if ($keys !== []) {
                foreach ($intervalIds as $intervalId) {
                    $key = array_search($intervalId, array_column($keys, 'fact_interval_id'));
                    if ($key !== false) {
                        foreach ($keys as $key) {
                            if ($key['fact_interval_id'] == $intervalId) {
                                $positions[] = explode(' (',$key['value'])[0];
                                break;
                            }
                        }
                    } else {
                        $positions[] = '-';
                    }
                }
                $leagues['items'][] = ['label' => $value['label'], 'value' => $positions];
            }
            else if ($value['country'] === $club['country'] || $value['country'] == 'all') {
                foreach ($intervalIds as $intervalId) {
                    $positions[] = '-';
                }
                $leagues['items'][] = ['label' => $value['label'], 'value' => $positions];
            }
        }
        if ($club['country'] == $forCheck['country']) {
            $keys = array_filter($result, function($element) use($forCheck){
                return $element['label'] == $forCheck['key'];
            });
            if ($keys !== []) {
                $dfb_pokal = array_search($forCheck['key'], array_column($leagues['items'], 'label'));
                $dfbPokal = array_search(str_replace('-', ' ', $forCheck['key']), array_column($leagues['items'], 'label'));
                $leagues['items'][$dfbPokal]['value'] = $leagues['items'][$dfb_pokal]['value'];
                unset($leagues['items'][$dfb_pokal]);
            }
        }

        return [
            'tabs' => [
                [
                    'label' => 'Financial Overview',
                    'items' => ['withActual' => [$incomeStatementData, $balanceSheetData], 'withoutActual' => [$playerTransferData]],
                ],
                [
                    'label' => 'Club Overview',
                    'items' => [
                        'clubList' => $infos, 'squadInfo' => $infoSquad, 'leagues' => $leagues, 'attendance' => $averageData,
                        'sponsors'   => [
                            'label' => 'Sponsors',
                            'items' => app(GetSponsorsForSnapshotTask::class)->run($user_id)
                        ],
                        'socialMedia' => [
                            'label' => 'Social Media',
                            'items' => app(GetFollowersForSnapshotTask::class)->run($user_id)
                        ],
                        'clubHonours' => [
                            'label' => 'Honours Won',
                            'items' => app(GetHonoursWonTask::class)->run($club)
                        ],
                    ],
                ],
            ],
            'defaultCurrency' => $items['defaultCurrency'],
            'intervals' => $intervals,
            'seasons' => $items['seasons'],
            'positions' => array_values(app(GetLeaguePositionTask::class)->run($this->decode($club['id']), count($averageData['seasons']))),
            'club' => $club
        ];
    }

    /**
     * @param $numberOne
     * @param $numberTwo
     * @return float|int
     */
    private function calculateGrowth($numberOne, $numberTwo)
    {
        $diff = $numberTwo - $numberOne;
        if ($numberOne == 0 && $numberTwo > 0) {
            $growth = 100;
        } elseif ($numberTwo == 0 && $numberOne > 0) {
            $growth = -100;
        } elseif ($numberTwo == 0 && $numberOne == 0) {
            $growth = 0;
        } else {
            $growth = $diff / $numberOne * 100;
        }
        return $growth;
    }
}
