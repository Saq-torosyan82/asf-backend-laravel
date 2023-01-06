<?php

namespace App\Containers\AppSection\Financial\Tasks\ImportClubData;

use App\Containers\AppSection\Financial\Tasks\CreateOrUpdateFactValueTask;
use App\Containers\AppSection\System\Enums\Currency;
use App\Containers\AppSection\System\Tasks\FindCountryByIdTask;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Containers\AppSection\Financial\Helpers as helpers;
use App\Containers\AppSection\Financial\Data\Repositories\{FactIntervalRepository,
    FactNameRepository,
    FactValueRepository,
    FinancialItemRepository,
    FinancialDataRepository,
    FinancialRepository,
    FinancialSeasonRepository
};
use App\Containers\AppSection\System\Data\Repositories\{
    CountryRepository,
    SportClubRepository,
    SportLeagueRepository,
    SportRepository
};
use App\Containers\AppSection\System\Models\{
    SportClub,
    SportLeague,
    Country,
    Sport
};
use App\Containers\AppSection\Financial\Tasks\ImportClubData\BaseTask as BaseImportTask;
use function PHPUnit\Framework\isEmpty;

class FinancialDataNewTask extends BaseImportTask
{
    public function run($file_path, &$error_message = '')
    {
        @unlink(env('DEBUG_FILE_PATH'));
//        $this->setImportType('financial_new');
//        parent::run($file_path, $error_message);
        $this->importDatasTest($file_path);
    }

    private static function getMap()
    {
        return [
            // -------------------------------- Sheet 0 (Key Metrics) ----------------------------------------
            'Key Metrics' => [
                'section_id' => 4,
                'leagues' => [
                    'A18' => [
                        'values' => [
                            'B1' => 'B18',
                            'C1' => 'C18',
                            'D1' => 'D18',
                            'E1' => 'E18',
                        ],
                    ],
                    'A19' => [
                        'values' => [
                            'B1' => 'B19',
                            'C1' => 'C19',
                            'D1' => 'D19',
                            'E1' => 'E19',
                        ],
                    ],
                    'A20' => [
                        'values' => [
                            'B1' => 'B20',
                            'C1' => 'C20',
                            'D1' => 'D20',
                            'E1' => 'E20',
                        ],
                    ],
                    'A21' => [
                        'values' => [
                            'B1' => 'B21',
                            'C1' => 'C21',
                            'D1' => 'D21',
                            'E1' => 'E21',
                        ],
                    ],
                    'A22' => [
                        'values' => [
                            'B1' => 'B22',
                            'C1' => 'C22',
                            'D1' => 'D22',
                            'E1' => 'E22',
                        ],
                    ],
                ],
                'data' => [
                    'B74' => [
                        'values' => [
                            'A78' => 'B78',
                            'A79' => 'B79',
                            'A80' => 'B80',
                            'A81' => 'B81',
                            'A82' => 'B82',
                        ],
                        'label' => 'Sales'
                    ],
                    'C74' => [
                        'values' => [
                            'A78' => 'C78',
                            'A79' => 'C79',
                            'A80' => 'C80',
                            'A81' => 'C81',
                            'A82' => 'C82',
                        ],
                        'label' => 'Acquisitions'
                    ],
                    'B28' => [
                        'values' => [
                            'A32' => 'B32',
                            'A33' => 'B33',
                            'A34' => 'B34',
                            'A35' => 'B35',
                            'A36' => 'B36',
                        ],
                        'label' => 'Average attendance'
                    ],
                    'C28' => [
                        'values' => [
                            'A32' => 'C32',
                            'A33' => 'C33',
                            'A34' => 'C34',
                            'A35' => 'C35',
                            'A36' => 'C36',
                        ],
                        'label' => 'Unused capacity'
                    ],
                ],
            ],
            // -------------------------------- Sheet 1 (P&L) ----------------------------------------
            'Income Statement' => [
                'section_id' => 1,
                'data' => [
                    //---- Revenues ------------------------------
                    'A5' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B5',
                            'C4' => 'C5',
                            'D4' => 'D5',
                            'E4' => 'E5',
                            'F4' => 'F5',
                            'G4' => 'G5',
                            'H4' => 'H5'
                        ],
                        'label' => 'Total operating revenue'
                    ],

                    // ---- Broadcasting ------------------------------
                    'A6' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B6',
                            'C4' => 'C6',
                            'D4' => 'D6',
                            'E4' => 'E6',
                            'F4' => 'F6',
                            'G4' => 'G6',
                            'H4' => 'H6'
                        ]
                    ],

                    // ---- Commercial ------------------------------
                    'A7' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B7',
                            'C4' => 'C7',
                            'D4' => 'D7',
                            'E4' => 'E7',
                            'F4' => 'F7',
                            'G4' => 'G7',
                            'H4' => 'H7'
                        ]
                    ],

                    // ---- Matchday ------------------------------
                    'A8' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B8',
                            'C4' => 'C8',
                            'D4' => 'D8',
                            'E4' => 'E8',
                            'F4' => 'F8',
                            'G4' => 'G8',
                            'H4' => 'H8'
                        ]
                    ],

                    // ---- Others ------------------------------
                    'A9' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B9',
                            'C4' => 'C9',
                            'D4' => 'D9',
                            'E4' => 'E9',
                            'F4' => 'F9',
                            'G4' => 'G9',
                            'H4' => 'H9'
                        ]
                    ],

                    // ---- Operating Expenses ------------------------------
                    'A11' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B11',
                            'C4' => 'C11',
                            'D4' => 'D11',
                            'E4' => 'E11',
                            'F4' => 'F11',
                            'G4' => 'G11',
                            'H4' => 'H11'
                        ]
                    ],

                    // ---- Staff costs ------------------------------
                    'A12' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B12',
                            'C4' => 'C12',
                            'D4' => 'D12',
                            'E4' => 'E12',
                            'F4' => 'F12',
                            'G4' => 'G12',
                            'H4' => 'H12'
                        ]
                    ],

                    // ---- Other operating costs ------------------------------
                    'A13' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B13',
                            'C4' => 'C13',
                            'D4' => 'D13',
                            'E4' => 'E13',
                            'F4' => 'F13',
                            'G4' => 'G13',
                            'H4' => 'H13'
                        ]
                    ],

                    // ---- Operating Profit/(Loss) ------------------------------
                    'A15' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B15',
                            'C4' => 'C15',
                            'D4' => 'D15',
                            'E4' => 'E15',
                            'F4' => 'F15',
                            'G4' => 'G15',
                            'H4' => 'H15'
                        ]
                    ],

                    // ---- Player trading ------------------------------
                    'A17' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B17',
                            'C4' => 'C17',
                            'D4' => 'D17',
                            'E4' => 'E17',
                            'F4' => 'F17',
                            'G4' => 'G17',
                            'H4' => 'H17'
                        ]
                    ],

                    // ---- Revenues/(costs) w.r.t. player loans  ------------------------------
                    'A18' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B18',
                            'C4' => 'C18',
                            'D4' => 'D18',
                            'E4' => 'E18',
                            'F4' => 'F18',
                            'G4' => 'G18',
                            'H4' => 'H18'
                        ]
                    ],

                    // ---- Profit/(loss) on Player sales  ------------------------------
                    'A19' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B19',
                            'C4' => 'C19',
                            'D4' => 'D19',
                            'E4' => 'E19',
                            'F4' => 'F19',
                            'G4' => 'G19',
                            'H4' => 'H19'
                        ]
                    ],

                    // ---- Amortisation of Players' registrations  ------------------------------
                    'A20' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B20',
                            'C4' => 'C20',
                            'D4' => 'D20',
                            'E4' => 'E20',
                            'F4' => 'F20',
                            'G4' => 'G20',
                            'H4' => 'H20'
                        ]
                    ],

                    // ---- Impairment of Players' registrations  ------------------------------
                    'A21' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B21',
                            'C4' => 'C21',
                            'D4' => 'D21',
                            'E4' => 'E21',
                            'F4' => 'F21',
                            'G4' => 'G21',
                            'H4' => 'H21'
                        ]
                    ],

                    // ---- Earnings before interest and tax (EBIT)  ------------------------------
                    'A23' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B23',
                            'C4' => 'C23',
                            'D4' => 'D23',
                            'E4' => 'E23',
                            'F4' => 'F23',
                            'G4' => 'G23',
                            'H4' => 'H23'
                        ]
                    ],

                    // ---- Net Finance Income / Cost  ------------------------------
                    'A25' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B25',
                            'C4' => 'C25',
                            'D4' => 'D25',
                            'E4' => 'E25',
                            'F4' => 'F25',
                            'G4' => 'G25',
                            'H4' => 'H25'
                        ]
                    ],

                    // ---- Finance Income  ------------------------------
                    'A26' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B26',
                            'C4' => 'C26',
                            'D4' => 'D26',
                            'E4' => 'E26',
                            'F4' => 'F26',
                            'G4' => 'G26',
                            'H4' => 'H26'
                        ]
                    ],

                    // ---- Finance Cost  ------------------------------
                    'A27' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B27',
                            'C4' => 'C27',
                            'D4' => 'D27',
                            'E4' => 'E27',
                            'F4' => 'F27',
                            'G4' => 'G27',
                            'H4' => 'H27'
                        ]
                    ],

                    // ---- Net Non-operating Income / Costs  ------------------------------
                    'A29' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B29',
                            'C4' => 'C29',
                            'D4' => 'D29',
                            'E4' => 'E29',
                            'F4' => 'F29',
                            'G4' => 'G29',
                            'H4' => 'H29'
                        ]
                    ],

                    // ---- Pre-tax Profit/(Loss)  ------------------------------
                    'A31' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B31',
                            'C4' => 'C31',
                            'D4' => 'D31',
                            'E4' => 'E31',
                            'F4' => 'F31',
                            'G4' => 'G31',
                            'H4' => 'H31'
                        ]
                    ],

                    // ---- Tax  ------------------------------
                    'A33' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B33',
                            'C4' => 'C33',
                            'D4' => 'D33',
                            'E4' => 'E33',
                            'F4' => 'F33',
                            'G4' => 'G33',
                            'H4' => 'H33'
                        ]
                    ],

                    // ---- Profit/loss after tax  ------------------------------
                    'A35' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B35',
                            'C4' => 'C35',
                            'D4' => 'D35',
                            'E4' => 'E35',
                            'F4' => 'F35',
                            'G4' => 'G35',
                            'H4' => 'H35'
                        ]
                    ],
                ]
            ],

            // -------------------------------- Sheet 2 (BS) ----------------------------------------
            'Balance Sheet' => [
                'section_id' => 2,
                'data' => [
                    //---------- Total Assets: -------------------
                    'A6' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B6',
                            'C4' => 'C6',
                            'D4' => 'D6',
                            'E4' => 'E6',
                            'F4' => 'F6',
                            'G4' => 'G6',
                            'H4' => 'H6'
                        ]
                    ],

                    //---------- Non-current assets -------------------
                    'A7' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B7',
                            'C4' => 'C7',
                            'D4' => 'D7',
                            'E4' => 'E7',
                            'F4' => 'F7',
                            'G4' => 'G7',
                            'H4' => 'H7'
                        ]
                    ],

                    //---------- Properties and facilities -------------------
                    'A8' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B8',
                            'C4' => 'C8',
                            'D4' => 'D8',
                            'E4' => 'E8',
                            'F4' => 'F8',
                            'G4' => 'G8',
                            'H4' => 'H8'
                        ]
                    ],

                    //---------- Players' registrations -------------------
                    'A9' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B9',
                            'C4' => 'C9',
                            'D4' => 'D9',
                            'E4' => 'E9',
                            'F4' => 'F9',
                            'G4' => 'G9',
                            'H4' => 'H9'
                        ]
                    ],

                    //---------- Goodwill -------------------
                    'A10' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B10',
                            'C4' => 'C10',
                            'D4' => 'D10',
                            'E4' => 'E10',
                            'F4' => 'F10',
                            'G4' => 'G10',
                            'H4' => 'H10'
                        ]
                    ],

                    //---------- Non-current assets - Debtors -------------------
                    'A11' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B11',
                            'C4' => 'C11',
                            'D4' => 'D11',
                            'E4' => 'E11',
                            'F4' => 'F11',
                            'G4' => 'G11',
                            'H4' => 'H11'
                        ],
                        'parent_cell' => 'A7'
                    ],

                    //---------- Non-current assets - Debtors - Trade debtors -------------------
                    'A12' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B12',
                            'C4' => 'C12',
                            'D4' => 'D12',
                            'E4' => 'E12',
                            'F4' => 'F12',
                            'G4' => 'G12',
                            'H4' => 'H12'
                        ],
                        'parent_cell' => 'A7'
                    ],

                    //---------- Non-current assets - Debtors -  Player debtors -------------------
                    'A13' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B13',
                            'C4' => 'C13',
                            'D4' => 'D13',
                            'E4' => 'E13',
                            'F4' => 'F13',
                            'G4' => 'G13',
                            'H4' => 'H13'
                        ],
                        'parent_cell' => 'A7'
                    ],

                    //---------- Right of use assets (lease) -------------------
                    'A14' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B14',
                            'C4' => 'C14',
                            'D4' => 'D14',
                            'E4' => 'E14',
                            'F4' => 'F14',
                            'G4' => 'G14',
                            'H4' => 'H14'
                        ]
                    ],

                    //---------- Investments -------------------
                    'A15' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B15',
                            'C4' => 'C15',
                            'D4' => 'D15',
                            'E4' => 'E15',
                            'F4' => 'F15',
                            'G4' => 'G15',
                            'H4' => 'H15'
                        ]
                    ],

                    //---------- Deferred tax -------------------
                    'A16' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B16',
                            'C4' => 'C16',
                            'D4' => 'D16',
                            'E4' => 'E16',
                            'F4' => 'F16',
                            'G4' => 'G16',
                            'H4' => 'H16'
                        ]
                    ],

                    //---------- Derivative financial instruments -------------------
                    'A17' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B17',
                            'C4' => 'C17',
                            'D4' => 'D17',
                            'E4' => 'E17',
                            'F4' => 'F17',
                            'G4' => 'G17',
                            'H4' => 'H17'
                        ]
                    ],

                    //---------- Other non-current assets -------------------
                    'A18' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B18',
                            'C4' => 'C18',
                            'D4' => 'D18',
                            'E4' => 'E18',
                            'F4' => 'F18',
                            'G4' => 'G18',
                            'H4' => 'H18'
                        ]
                    ],

                    //---------- Current assets -------------------
                    'A20' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B20',
                            'C4' => 'C20',
                            'D4' => 'D20',
                            'E4' => 'E20',
                            'F4' => 'F20',
                            'G4' => 'G20',
                            'H4' => 'H20'
                        ]
                    ],

                    //---------- Cash and cash equivalents -------------------
                    'A21' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B21',
                            'C4' => 'C21',
                            'D4' => 'D21',
                            'E4' => 'E21',
                            'F4' => 'F21',
                            'G4' => 'G21',
                            'H4' => 'H21'
                        ]
                    ],

                    //---------- Stock/Inventory -------------------
                    'A22' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B22',
                            'C4' => 'C22',
                            'D4' => 'D22',
                            'E4' => 'E22',
                            'F4' => 'F22',
                            'G4' => 'G22',
                            'H4' => 'H22'
                        ]
                    ],

                    //---------- Current assets - Debtors -------------------
                    'A23' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B23',
                            'C4' => 'C23',
                            'D4' => 'D23',
                            'E4' => 'E23',
                            'F4' => 'F23',
                            'G4' => 'G23',
                            'H4' => 'H23'
                        ],
                        'parent_cell' => 'A20'
                    ],

                    //---------- Non-current assets - Debtors - Trade debtors -------------------
                    'A24' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B24',
                            'C4' => 'C24',
                            'D4' => 'D24',
                            'E4' => 'E24',
                            'F4' => 'F24',
                            'G4' => 'G24',
                            'H4' => 'H24'
                        ],
                        'parent_cell' => 'A20'
                    ],

                    //---------- Non-current assets - Debtors - Player debtors -------------------
                    'A25' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B25',
                            'C4' => 'C25',
                            'D4' => 'D25',
                            'E4' => 'E25',
                            'F4' => 'F25',
                            'G4' => 'G25',
                            'H4' => 'H25'
                        ],
                        'parent_cell' => 'A20'
                    ],

                    //---------- Prepayments and accrued income -------------------
                    'A26' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B26',
                            'C4' => 'C26',
                            'D4' => 'D26',
                            'E4' => 'E26',
                            'F4' => 'F26',
                            'G4' => 'G26',
                            'H4' => 'H26'
                        ]
                    ],

                    //---------- Other current assets -------------------
                    'A27' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B27',
                            'C4' => 'C27',
                            'D4' => 'D27',
                            'E4' => 'E27',
                            'F4' => 'F27',
                            'G4' => 'G27',
                            'H4' => 'H27'
                        ]
                    ],

                    //---------- Total Liabilities: -------------------
                    'A29' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B29',
                            'C4' => 'C29',
                            'D4' => 'D29',
                            'E4' => 'E29',
                            'F4' => 'F29',
                            'G4' => 'G29',
                            'H4' => 'H29'
                        ]
                    ],

                    //---------- Equity -------------------
                    'A30' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B30',
                            'C4' => 'C30',
                            'D4' => 'D30',
                            'E4' => 'E30',
                            'F4' => 'F30',
                            'G4' => 'G30',
                            'H4' => 'H30'
                        ]
                    ],

                    //---------- Share capital -------------------
                    'A31' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B31',
                            'C4' => 'C31',
                            'D4' => 'D31',
                            'E4' => 'E31',
                            'F4' => 'F31',
                            'G4' => 'G31',
                            'H4' => 'H31'
                        ]
                    ],

                    //---------- Capital premium -------------------
                    'A32' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B32',
                            'C4' => 'C32',
                            'D4' => 'D32',
                            'E4' => 'E32',
                            'F4' => 'F32',
                            'G4' => 'G32',
                            'H4' => 'H32'
                        ]
                    ],

                    //---------- Other reserves -------------------
                    'A33' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B33',
                            'C4' => 'C33',
                            'D4' => 'D33',
                            'E4' => 'E33',
                            'F4' => 'F33',
                            'G4' => 'G33',
                            'H4' => 'H33'
                        ]
                    ],

                    //---------- Retained earnings -------------------
                    'A34' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B34',
                            'C4' => 'C34',
                            'D4' => 'D34',
                            'E4' => 'E34',
                            'F4' => 'F34',
                            'G4' => 'G34',
                            'H4' => 'H34'
                        ]
                    ],

                    //---------- Minority interest -------------------
                    'A35' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B35',
                            'C4' => 'C35',
                            'D4' => 'D35',
                            'E4' => 'E35',
                            'F4' => 'F35',
                            'G4' => 'G35',
                            'H4' => 'H35'
                        ]
                    ],

                    //---------- Non-current liabilities -------------------
                    'A37' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B37',
                            'C4' => 'C37',
                            'D4' => 'D37',
                            'E4' => 'E37',
                            'F4' => 'F37',
                            'G4' => 'G37',
                            'H4' => 'H37'
                        ]
                    ],

                    //---------- Non-current liabilities - Shareholder loans -------------------
                    'A38' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B38',
                            'C4' => 'C38',
                            'D4' => 'D38',
                            'E4' => 'E38',
                            'F4' => 'F38',
                            'G4' => 'G38',
                            'H4' => 'H38'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Non-current liabilities - Interest bearing -------------------
                    'A39' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B39',
                            'C4' => 'C39',
                            'D4' => 'D39',
                            'E4' => 'E39',
                            'F4' => 'F39',
                            'G4' => 'G39',
                            'H4' => 'H39'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Non-current liabilities - Non-interest bearing -------------------
                    'A40' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B40',
                            'C4' => 'C40',
                            'D4' => 'D40',
                            'E4' => 'E40',
                            'F4' => 'F40',
                            'G4' => 'G40',
                            'H4' => 'H40'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Non-current liabilities - Loans and borrowings -------------------
                    'A41' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B41',
                            'C4' => 'C41',
                            'D4' => 'D41',
                            'E4' => 'E41',
                            'F4' => 'F41',
                            'G4' => 'G41',
                            'H4' => 'H41'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Non-current liabilities - Creditors -------------------
                    'A42' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B42',
                            'C4' => 'C42',
                            'D4' => 'D42',
                            'E4' => 'E42',
                            'F4' => 'F42',
                            'G4' => 'G42',
                            'H4' => 'H42'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Non-current liabilities - Trade creditors -------------------
                    'A43' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B43',
                            'C4' => 'C43',
                            'D4' => 'D43',
                            'E4' => 'E43',
                            'F4' => 'F43',
                            'G4' => 'G43',
                            'H4' => 'H43'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Non-current liabilities - Player creditors -------------------
                    'A44' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B44',
                            'C4' => 'C44',
                            'D4' => 'D44',
                            'E4' => 'E44',
                            'F4' => 'F44',
                            'G4' => 'G44',
                            'H4' => 'H44'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Deferred tax liability -------------------
                    'A45' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B45',
                            'C4' => 'C45',
                            'D4' => 'D45',
                            'E4' => 'E45',
                            'F4' => 'F45',
                            'G4' => 'G45',
                            'H4' => 'H45'
                        ]
                    ],

                    //---------- Non-current liabilities - Tax and social contributions -------------------
                    'A46' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B46',
                            'C4' => 'C46',
                            'D4' => 'D46',
                            'E4' => 'E46',
                            'F4' => 'F46',
                            'G4' => 'G46',
                            'H4' => 'H46'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Non-current liabilities - Accruals and deferred income -------------------
                    'A47' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B47',
                            'C4' => 'C47',
                            'D4' => 'D47',
                            'E4' => 'E47',
                            'F4' => 'F47',
                            'G4' => 'G47',
                            'H4' => 'H47'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Non-current liabilities - Lease liabilities -------------------
                    'A48' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B48',
                            'C4' => 'C48',
                            'D4' => 'D48',
                            'E4' => 'E48',
                            'F4' => 'F48',
                            'G4' => 'G48',
                            'H4' => 'H48'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Non-current liabilities - Provisions -------------------
                    'A49' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B49',
                            'C4' => 'C49',
                            'D4' => 'D49',
                            'E4' => 'E49',
                            'F4' => 'F49',
                            'G4' => 'G49',
                            'H4' => 'H49'
                        ],
                        'parent_cell' => 'A37'
                    ],

                    //---------- Other non-current liabilities -------------------
                    'A50' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B50',
                            'C4' => 'C50',
                            'D4' => 'D50',
                            'E4' => 'E50',
                            'F4' => 'F50',
                            'G4' => 'G50',
                            'H4' => 'H50'
                        ]
                    ],

                    //---------- Current liabilities -------------------
                    'A52' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B52',
                            'C4' => 'C52',
                            'D4' => 'D52',
                            'E4' => 'E52',
                            'F4' => 'F52',
                            'G4' => 'G52',
                            'H4' => 'H52'
                        ]
                    ],

                    //---------- Current liabilities - Shareholder loans -------------------
                    'A53' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B53',
                            'C4' => 'C53',
                            'D4' => 'D53',
                            'E4' => 'E53',
                            'F4' => 'F53',
                            'G4' => 'G53',
                            'H4' => 'H53'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Interest bearing -------------------
                    'A54' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B54',
                            'C4' => 'C54',
                            'D4' => 'D54',
                            'E4' => 'E54',
                            'F4' => 'F54',
                            'G4' => 'G54',
                            'H4' => 'H54'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Non-interest bearing -------------------
                    'A55' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B55',
                            'C4' => 'C55',
                            'D4' => 'D55',
                            'E4' => 'E55',
                            'F4' => 'F55',
                            'G4' => 'G55',
                            'H4' => 'H55'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Loans and borrowings -------------------
                    'A56' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B56',
                            'C4' => 'C56',
                            'D4' => 'D56',
                            'E4' => 'E56',
                            'F4' => 'F56',
                            'G4' => 'G56',
                            'H4' => 'H56'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Creditors -------------------
                    'A57' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B57',
                            'C4' => 'C57',
                            'D4' => 'D57',
                            'E4' => 'E57',
                            'F4' => 'F57',
                            'G4' => 'G57',
                            'H4' => 'H57'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Trade creditors -------------------
                    'A58' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B58',
                            'C4' => 'C58',
                            'D4' => 'D58',
                            'E4' => 'E58',
                            'F4' => 'F58',
                            'G4' => 'G58',
                            'H4' => 'H58'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Player creditors -------------------
                    'A59' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B59',
                            'C4' => 'C59',
                            'D4' => 'D59',
                            'E4' => 'E59',
                            'F4' => 'F59',
                            'G4' => 'G59',
                            'H4' => 'H59'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Tax and social contributions -------------------
                    'A60' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B60',
                            'C4' => 'C60',
                            'D4' => 'D60',
                            'E4' => 'E60',
                            'F4' => 'F60',
                            'G4' => 'G60',
                            'H4' => 'H60'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Accruals and deferred income -------------------
                    'A61' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B61',
                            'C4' => 'C61',
                            'D4' => 'D61',
                            'E4' => 'E61',
                            'F4' => 'F61',
                            'G4' => 'G61',
                            'H4' => 'H61'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Lease liabilities -------------------
                    'A62' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B62',
                            'C4' => 'C62',
                            'D4' => 'D62',
                            'E4' => 'E62',
                            'F4' => 'F62',
                            'G4' => 'G62',
                            'H4' => 'H62'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Current liabilities - Provisions -------------------
                    'A63' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B63',
                            'C4' => 'C63',
                            'D4' => 'D63',
                            'E4' => 'E63',
                            'F4' => 'F63',
                            'G4' => 'G63',
                            'H4' => 'H63'
                        ],
                        'parent_cell' => 'A52'
                    ],

                    //---------- Other current liabilities -------------------
                    'A64' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B64',
                            'C4' => 'C64',
                            'D4' => 'D64',
                            'E4' => 'E64',
                            'F4' => 'F64',
                            'G4' => 'G64',
                            'H4' => 'H64'
                        ]
                    ]
                ]
            ],

            // -------------------------------- Sheet 3 (CF) ----------------------------------------
            'Cashflow' => [
                'section_id' => 3,
                'data' => [
                    //---------- Profit/(Loss) after taxation -------------------
                    'A5' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B5',
                            'C4' => 'C5',
                            'D4' => 'D5',
                            'E4' => 'E5',
                            'F4' => 'F5',
                            'G4' => 'G5',
                            'H4' => 'H5'
                        ]
                    ],

                    //---------- -/+ gains/(losses) on player sales -------------------
                    'A6' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B6',
                            'C4' => 'C6',
                            'D4' => 'D6',
                            'E4' => 'E6',
                            'F4' => 'F6',
                            'G4' => 'G6',
                            'H4' => 'H6'
                        ]
                    ],

                    //---------- +/- Amortisation & Depreciation -------------------
                    'A7' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B7',
                            'C4' => 'C7',
                            'D4' => 'D7',
                            'E4' => 'E7',
                            'F4' => 'F7',
                            'G4' => 'G7',
                            'H4' => 'H7'
                        ]
                    ],

                    //---------- Loss/(profit) on sale of tangible assets -------------------
                    'A8' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B8',
                            'C4' => 'C8',
                            'D4' => 'D8',
                            'E4' => 'E8',
                            'F4' => 'F8',
                            'G4' => 'G8',
                            'H4' => 'H8'
                        ]
                    ],

                    //---------- Net finance income -------------------
                    'A9' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B9',
                            'C4' => 'C9',
                            'D4' => 'D9',
                            'E4' => 'E9',
                            'F4' => 'F9',
                            'G4' => 'G9',
                            'H4' => 'H9'
                        ]
                    ],

                    //---------- Taxation expense/(credit) -------------------
                    'A10' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B10',
                            'C4' => 'C10',
                            'D4' => 'D10',
                            'E4' => 'E10',
                            'F4' => 'F10',
                            'G4' => 'G10',
                            'H4' => 'H10'
                        ]
                    ],

                    //---------- Accrued (income)/expenses -------------------
                    'A11' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B11',
                            'C4' => 'C11',
                            'D4' => 'D11',
                            'E4' => 'E11',
                            'F4' => 'F11',
                            'G4' => 'G11',
                            'H4' => 'H11'
                        ]
                    ],

                    //---------- TV & broadcasting rebate -------------------
                    'A12' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B12',
                            'C4' => 'C12',
                            'D4' => 'D12',
                            'E4' => 'E12',
                            'F4' => 'F12',
                            'G4' => 'G12',
                            'H4' => 'H12'
                        ]
                    ],

                    //---------- Decrease/(increase) in debtors -------------------
                    'A13' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B13',
                            'C4' => 'C13',
                            'D4' => 'D13',
                            'E4' => 'E13',
                            'F4' => 'F13',
                            'G4' => 'G13',
                            'H4' => 'H13'
                        ]
                    ],

                    //---------- Decrease/(increase) in stocks -------------------
                    'A14' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B14',
                            'C4' => 'C14',
                            'D4' => 'D14',
                            'E4' => 'E14',
                            'F4' => 'F14',
                            'G4' => 'G14',
                            'H4' => 'H14'
                        ]
                    ],

                    //---------- (Decrease)/increase in creditors -------------------
                    'A15' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B15',
                            'C4' => 'C15',
                            'D4' => 'D15',
                            'E4' => 'E15',
                            'F4' => 'F15',
                            'G4' => 'G15',
                            'H4' => 'H15'
                        ]
                    ],

                    //---------- Decrease/(increase) in other current assets -------------------
                    'A16' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B16',
                            'C4' => 'C16',
                            'D4' => 'D16',
                            'E4' => 'E16',
                            'F4' => 'F16',
                            'G4' => 'G16',
                            'H4' => 'H16'
                        ]
                    ],

                    //---------- (Decrease)/increase in other current liabilities -------------------
                    'A17' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B17',
                            'C4' => 'C17',
                            'D4' => 'D17',
                            'E4' => 'E17',
                            'F4' => 'F17',
                            'G4' => 'G17',
                            'H4' => 'H17'
                        ]
                    ],

                    //---------- Non-cash movement -------------------
                    'A18' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B18',
                            'C4' => 'C18',
                            'D4' => 'D18',
                            'E4' => 'E18',
                            'F4' => 'F18',
                            'G4' => 'G18',
                            'H4' => 'H18'
                        ]
                    ],

                    //---------- A) Net Cash from Operating Activities -------------------
                    'A19' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B19',
                            'C4' => 'C19',
                            'D4' => 'D19',
                            'E4' => 'E19',
                            'F4' => 'F19',
                            'G4' => 'G19',
                            'H4' => 'H19'
                        ]
                    ],

                    //---------- Change in fixed assets -------------------
                    'A21' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B21',
                            'C4' => 'C21',
                            'D4' => 'D21',
                            'E4' => 'E21',
                            'F4' => 'F21',
                            'G4' => 'G21',
                            'H4' => 'H21'
                        ]
                    ],

                    //---------- Change in player registrations -------------------
                    'A22' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B22',
                            'C4' => 'C22',
                            'D4' => 'D22',
                            'E4' => 'E22',
                            'F4' => 'F22',
                            'G4' => 'G22',
                            'H4' => 'H22'
                        ]
                    ],

                    //---------- Finance Income -------------------
                    'A23' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B23',
                            'C4' => 'C23',
                            'D4' => 'D23',
                            'E4' => 'E23',
                            'F4' => 'F23',
                            'G4' => 'G23',
                            'H4' => 'H23'
                        ]
                    ],

                    //---------- B) Net Cash from Investing Activities -------------------
                    'A24' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B24',
                            'C4' => 'C24',
                            'D4' => 'D24',
                            'E4' => 'E24',
                            'F4' => 'F24',
                            'G4' => 'G24',
                            'H4' => 'H24'
                        ]
                    ],

                    //---------- New Loans - external -------------------
                    'A26' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B26',
                            'C4' => 'C26',
                            'D4' => 'D26',
                            'E4' => 'E26',
                            'F4' => 'F26',
                            'G4' => 'G26',
                            'H4' => 'H26'
                        ]
                    ],

                    //---------- Repayment of loans - external -------------------
                    'A27' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B27',
                            'C4' => 'C27',
                            'D4' => 'D27',
                            'E4' => 'E27',
                            'F4' => 'F27',
                            'G4' => 'G27',
                            'H4' => 'H27'
                        ]
                    ],

                    //---------- New Loans - shareholder -------------------
                    'A28' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B28',
                            'C4' => 'C28',
                            'D4' => 'D28',
                            'E4' => 'E28',
                            'F4' => 'F28',
                            'G4' => 'G28',
                            'H4' => 'H28'
                        ]
                    ],

                    //---------- Repayment of loans - shareholder -------------------
                    'A29' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B29',
                            'C4' => 'C29',
                            'D4' => 'D29',
                            'E4' => 'E29',
                            'F4' => 'F29',
                            'G4' => 'G29',
                            'H4' => 'H29'
                        ]
                    ],

                    //---------- Capital contributions paid in/paid out -------------------
                    'A30' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B30',
                            'C4' => 'C30',
                            'D4' => 'D30',
                            'E4' => 'E30',
                            'F4' => 'F30',
                            'G4' => 'G30',
                            'H4' => 'H30'
                        ]
                    ],

                    //---------- Financial expense -------------------
                    'A31' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B31',
                            'C4' => 'C31',
                            'D4' => 'D31',
                            'E4' => 'E31',
                            'F4' => 'F31',
                            'G4' => 'G31',
                            'H4' => 'H31'
                        ]
                    ],

                    //---------- Capital element of finance lease repaid -------------------
                    'A32' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B32',
                            'C4' => 'C32',
                            'D4' => 'D32',
                            'E4' => 'E32',
                            'F4' => 'F32',
                            'G4' => 'G32',
                            'H4' => 'H32'
                        ]
                    ],

                    //---------- Dividends paid -------------------
                    'A33' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B33',
                            'C4' => 'C33',
                            'D4' => 'D33',
                            'E4' => 'E33',
                            'F4' => 'F33',
                            'G4' => 'G33',
                            'H4' => 'H33'
                        ]
                    ],

                    //---------- C) Net Cash from Funding Activities -------------------
                    'A34' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B34',
                            'C4' => 'C34',
                            'D4' => 'D34',
                            'E4' => 'E34',
                            'F4' => 'F34',
                            'G4' => 'G34',
                            'H4' => 'H34'
                        ]
                    ],

                    //---------- Net Cash Flow -------------------
                    'A36' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B36',
                            'C4' => 'C36',
                            'D4' => 'D36',
                            'E4' => 'E36',
                            'F4' => 'F36',
                            'G4' => 'G36',
                            'H4' => 'H36'
                        ]
                    ],

                    //---------- Other - Tax Paid -------------------
                    'A37' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B37',
                            'C4' => 'C37',
                            'D4' => 'D37',
                            'E4' => 'E37',
                            'F4' => 'F37',
                            'G4' => 'G37',
                            'H4' => 'H37'
                        ]
                    ],

                    //---------- Opening cash balance -------------------
                    'A39' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B39',
                            'C4' => 'C39',
                            'D4' => 'D39',
                            'E4' => 'E39',
                            'F4' => 'F39',
                            'G4' => 'G39',
                            'H4' => 'H39'
                        ]
                    ],

                    //---------- Closing cash balance -------------------
                    'A40' => [ // item cell
                        'values' => [ // season_cell => value_cell
                            'B4' => 'B40',
                            'C4' => 'C40',
                            'D4' => 'D40',
                            'E4' => 'E40',
                            'F4' => 'F40',
                            'G4' => 'G40',
                            'H4' => 'H40'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @param string $str
     * @return array|string|string[]|null
     */
    private static function makeSlag($str)
    {
        $slag = preg_replace("/[^\w]/", "-", strtolower(trim($str)));
        return preg_replace("/-+/", "-", trim($slag, '-'));
    }

    function importDatasTest($file_path)
    {
        $averageAttendance = [];
        $club_path_parts = pathinfo($file_path);
        $clubName = $club_path_parts['filename'];

//        \DB::table('financials')->delete();
        $clubRepo = new SportClubRepository(app());
        $club = $clubRepo->findWhere(['name' => $clubName])->first();
        if ($club == null){
            die("\nClub with the name $clubName not found\n");
        }
        printf("\n\tImport financial for club [name: %s] [id: %d]", $club->name, $club->id);
        $countryInfo = app(FindCountryByIdTask::class)->run($club->country_id);
        $defaultCurrency = strtolower($countryInfo->name) == 'england' ? Currency::GBP : Currency::EUR;

        $financialRepo     = new FinancialRepository(app());
        $financialItemRepo = new FinancialItemRepository(app());
        $financialDataRepo = new FinancialDataRepository(app());
        $financialSeasons  = new FinancialSeasonRepository(app());
        $factIntervals     = new FactIntervalRepository(app());
        $factNames         = new FactNameRepository(app());

        $map = self::getMap();
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = IOFactory::load($file_path);

        foreach ($map as $sheetName => $sheetData) {
            printf("\n\t\tImporting data from [sheet: %s]", $sheetName);
            $sheet = $spreadsheet->getSheetByName($sheetName);

            if (empty($sheet)) {
                die("\nSheet: [$sheetName] is missing\n");
            }

            print("\n\t\t");
            if ($sheetName == "Key Metrics") {
                foreach ($sheetData['leagues'] as $itemCell => $details) {
                    $interval = $sheet->getCell($itemCell)->getValue();
                    $interval_id = $factIntervals->select('id')->where('interval', 'like', '%/' . explode('-', $interval)[1] . '%')->get()[0]['id'];
                    $factValueRow = [
                        'club_id' => $club->id,
                        'fact_name_id' => $factNames->select('id')->where('name', config('appSection-financial.league_label'))->where('factsection_id', '<>', null)->get()->toArray()[0]['id'],
                        'fact_interval_id' => $interval_id
                    ];
                    $factValueData = [
                        'value' => ''
                    ];
                    foreach ($details['values'] as $leagueCell => $positionCell) {
                        $league = $sheet->getCell($leagueCell)->getValue();
                        $position = $sheet->getCell($positionCell)->getValue();
                        if ($position != '') {
                            $factValueData['value'] = $this->changePositionFormat($position) . ' (' . $league . ')';
                        }
                    }
                    printf("\n\t\t%d =>  position: %s", $interval_id, $factValueData['value']);
                    app(CreateOrUpdateFactValueTask::class)->run($factValueRow, $factValueData);
                }

            } else {
                $celVal = $sheet->getCell("A2")->getValue();
                $celVal = trim($celVal);
                $numbersIn = explode(" ", $celVal)[1];
                printf("\n\t\t All numbers are in : %s", $numbersIn);
            }

            foreach ($sheetData['data'] as $itemCell => $details) {
                printf("\nItem cell: %s", $itemCell);
                $itemName = !empty($details['label']) ? $details['label'] : $sheet->getCell($itemCell)->getValue();
                printf("\nItem name: %s", $itemName);

                $financialItemCriteria = [
                    'item_slag'  => self::makeSlag($itemName),
                    'section_id' => $sheetData['section_id']
                ];

                if (!empty($details['parent_cell'])) {
                    printf("\nParent item cell: %s", $details['parent_cell']);
                    $parentItemName = !empty($sheetData[$details['parent_cell']]['label']) ? $sheetData[$details['parent_cell']]['label'] : $sheet->getCell($details['parent_cell'])->getValue();
                    printf("\nParent item name: %s", $parentItemName);
                    $parentItem = $financialItemRepo->findWhere(['item_slag' => self::makeSlag($parentItemName)])->first()->toArray();

                    if (!empty($parentItem)) {
                        $financialItemCriteria['group_id'] = $parentItem['group_id'];
                    }
                }

                echo "\nGetting financial item";
                $financialItem = $financialItemRepo->findWhere($financialItemCriteria)->first();

                if (!empty($financialItem)) {
                    printf("\nFinancial item id: %d", $financialItem->id);
                    print("\n\t\t\t");
                    foreach ($details['values'] as $seasonCell => $amountCell) {
                        //Find Season
                        printf("\nSeason cell: %s", $seasonCell);
                        $seasonValue = $sheet->getCell($seasonCell)->getValue();
                        printf("\nSeason value: %s", $seasonValue);
                        $seasonData = $financialSeasons->findWhere(['label' => $seasonValue])->first();

                        if (!empty($seasonData)) {
                            //Find Or create Financial
                            echo "\nFind Or create Financial";
                            $financialCriteria = [
                                'club_id' => $club->id,
                                'season_id' => $seasonData->id,
                                'currency' => $defaultCurrency,
                            ];
                            if ($sheetName != "Key Metrics") {
                                $financialCriteria['numbers_in'] = $numbersIn;
                            }
                            $financialData = $financialRepo->findWhere($financialCriteria)->first();
                            if (empty($financialData)) {
                                echo "\nNo financial found. Creating new";
                                //financial is missing
                                //TODO: add it
                                $financialData = $financialRepo->create($financialCriteria);
                            }
                            printf("\nFinancial id: %d", $financialData->id);

                            printf("\nAmount cell: %s", $amountCell);
                            $amountValue = $sheet->getCell($amountCell)->getCalculatedValue();
                            if ($financialItemCriteria['item_slag'] == 'average-attendance' || $financialItemCriteria['item_slag'] == 'unused-capacity'){
                                $averageAttendance[$financialData->id][] = $amountValue;
                                $avgAttendanceId = $financialItem->id;
                            }
                            printf("\nAmount value: %s", $amountValue);
                            //Add item
                            $financialRaw = [
                                'financial_id' => $financialData->id,
                                'item_id' => $financialItem->id,
                                'amount' => is_numeric($amountValue) ? $amountValue : 0
                            ];

                            echo "\nCreating financial data";
                            $finansial_data = $financialDataRepo->create($financialRaw);
                            printf("\nCreated financial data id: %d", $finansial_data->id);
                        }
                    }
                } else {
                    echo "\nFinancial item not found. \nContinue";
                }
            }
            }
        if ($averageAttendance) {
            foreach ($averageAttendance as $financialId => $amounts) {
                $numberOne = is_numeric($amounts[0]) ? $amounts[0] : 0;
                $numberTwo = is_numeric($amounts[1]) ? $amounts[1] : 0;
                $total = $numberOne + $numberTwo;
                if ($total == 0 ) {
                    $perc = 0;
                } else {
                    $perc = $amounts[0] / $total * 100;
                }
                $financialRawTotal = [
                    'financial_id' => $financialId,
                    'item_id' => $avgAttendanceId + 1,
                    'amount' => $total
                ];
                $financialDataRepo->create($financialRawTotal);
                $financialRawPer = [
                    'financial_id' => $financialId,
                    'item_id' => $avgAttendanceId + 2,
                    'amount' => $perc
                ];
                $financialDataRepo->create($financialRawPer);

            }
        }
    }

    /**
     * Import datas for a club
     */
    function importDatas(SportClub $club, $clubFilePath, &$error_message){
        printf("\n\tImport financial for club [name: %s] [id: %d]", $club->name, $club->id);
        $ignoreEmptyCells = true;

        $map = self::getMap();

        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = IOFactory::load($clubFilePath);

        $result = true;
        foreach($map as $sheet){
            foreach($sheet as $cell=>$details){
                printf("\n\t\tCell: " . $cell);
                $this->importData($club, $cell, $details, $spreadsheet);
            }
        }
        return $result;
    }

    function importData($club, $cell, $details, $spreadsheet){
        $clubRepo = new SportClubRepository(app());
        $financialRepo = new FinancialRepository(app());
        $financialItemRepo = new FinancialItemRepository(app());
        $financialDataRepo = new FinancialDataRepository(app());
        $financialSeasons = new FinancialSeasonRepository(app());

        $sheet = $spreadsheet->getSheet($details['sheet']);

        $item_name = $sheet->getCell($details['item_name'])->getValue();
        $item_value = $sheet->getCell($cell)->getCalculatedValue();
        $item_season = $sheet->getCell($details['season'])->getValue();
        printf("\n\t\t\tName: %s, Value: %s, Season: %s", $item_name, $item_value, $item_season);

        //Find Season
        $season_criteria = [
            'label' => $item_season,
            // 'club_id' => $club->id
        ];
        $season =  $financialSeasons->findWhere($season_criteria)->first();
        printf("\n\t\t\tSeason: %s", $season->label);
        if($season == null) die("Season is null");


        //Find Financial
        $financial_criteria = [
            'club_id' => $club->id,
            'season_id' => $season->id
        ];
        $financial =  $financialRepo->findWhere($financial_criteria)->first();
        if($financial == null){ //financial is missing
            // die("\nFinancial missing");
            //TODO: add it
            $financial_raw = [
                'club_id' => $club->id,
                'season_id' => $season->id,
            ];
            $financial = $financialRepo->create($financial_raw);
        }
        printf("\n\t\t\Financial id: %d", $financial->id);

        //Find financial item
        $financial_item_criteria = [
            'label' => $item_name
        ];
        $financial_item =  $financialItemRepo->findWhere($financial_item_criteria)->first();
        if($financial_item == null){ //financial is missing
            // $financial_item_raw = [
            //     'club_id' => $club->id,
            //     'season_id' => $season->id,
            // ];
            // $financial_item = $financialItemRepo->create($financial_item_raw);
            die("\n\t\t Financial item: [$item_name] is missing");
        }



        //Add item
        $financial_data_raw = [
            'financial_id' => $financial->id,
            'item_id' => $financial_item->id,
            'amount' => $item_value
        ];
        $financial_data = $financialDataRepo->create($financial_data_raw);
        printf("\n\t\t\tFinancial data created (id=%d, amount=%f)", $financial_data->id, $financial_data->amount);
    }
    private static function changePositionFormat($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if (($number%100) >= 11 && ($number%100) <= 13)
             return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
}
