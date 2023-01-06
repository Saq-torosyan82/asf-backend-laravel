<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\CreateFinancialItemTask;
use App\Ship\Parents\Seeders\Seeder;

class FinancialItemsSeeder_new extends Seeder
{
    public function run()
    {
        \DB::table('financial_items')->delete();

        $items = [
            // First section (P&L)
            //---- Revenues ------
            [
                'label'      => "Total operating revenue",
                'section_id' => 1,
                'group_id'   => 1,
                'style'      => "bold",
                'subs'       => [
                    "Broadcasting",
                    "Commercial",
                    "Matchday",
                    "Other"
                ]
            ],
            //---- Operating Expenses ------
            [
                'label'      => "Operating expenses",
                'section_id' => 1,
                'group_id'   => 2,
                'style'      => "bold",
                'subs'       => [
                    "Staff costs",
                    "Other operating costs"
                ]
            ],
            //---- Operating Profit/(Loss) ------
            [
                'label'      => "Operating Profit/(Loss)",
                'section_id' => 1,
                'group_id'   => 3,
                'style'      => "bold"
            ],
            //---- Player Trading ------
            [
                'label'      => "Player trading",
                'section_id' => 1,
                'group_id'   => 4,
                'style'      => "bold",
                'subs'       => [
                    "Revenues/(costs) w.r.t. player loans",
                    "Profit/(loss) on Player sales",
                    "Amortisation of Players' registrations",
                    "Impairment of Players' registrations"
                ]
            ],
            //---- Earnings before interest and tax (EBIT) ------
            [
                'label'      => "Earnings before interest and tax (EBIT)",
                'section_id' => 1,
                'group_id'   => 5,
                'style'      => "bold"
            ],
            //---- Net Finance Income/(Cost) ------
            [
                'label'      => "Net Finance Income/(Cost)",
                'section_id' => 1,
                'group_id'   => 6,
                'style'      => "bold",
                'subs'       => [
                    "Finance Income",
                    "Finance Cost",
                ]
            ],
            //---- Net Non-operating Income/(Cost) ------
            [
                'label'      => "Net Non-operating Income/(Cost)",
                'section_id' => 1,
                'group_id'   => 7,
                'style'      => "bold"
            ],
            //---- Pre-tax Profit/(Loss) ------
            [
                'label'      => "Pre-tax Profit/(Loss)",
                'section_id' => 1,
                'group_id'   => 8,
                'style'      => "bold"
            ],
            //---- Tax ------
            [
                'label'      => "Tax",
                'section_id' => 1,
                'group_id'   => 9,
                'style'      => "bold"
            ],
            //---- Profit/(Loss) After Tax ------
            [
                'label'      => "Profit/(Loss) after Tax",
                'section_id' => 1,
                'group_id'   => 10,
                'style'      => "bold"
            ],

            // Second section (BS)
            //---- Total Assets: ------
            [
                'label'      => "Total Assets:",
                'section_id' => 2,
                'group_id'   => 1,
                'style'      => "bold"
            ],

            //---- Non-current assets ------
            [
                'label'      => "Non-current assets",
                'section_id' => 2,
                'group_id'   => 2,
                'style'      => "bold",
                'subs'       => [
                    "Properties and facilities",
                    "Players' registrations",
                    "Goodwill",
                    "Debtors",
                    "Trade debtors",
                    "Player debtors",
                    "Right of use assets (lease)",
                    "Investments",
                    "Deferred tax",
                    "Derivative financial instruments",
                    "Other non-current assets",
                ]
            ],

            //---- Current assets ------
            [
                'label'      => "Current assets",
                'section_id' => 2,
                'group_id'   => 3,
                'style'      => "bold",
                'subs'       => [
                    "Cash and cash equivalents",
                    "Stock/inventory",
                    "Debtors",
                    "Trade debtors",
                    "Player debtors",
                    "Prepayments and accrued income",
                    "Other current assets"
                ]
            ],

            //---- Total Liabilities: ------
            [
                'label'      => "Total Liabilities:",
                'section_id' => 2,
                'group_id'   => 4,
                'style'      => "bold"
            ],

            //---- Equity ------
            [
                'label'      => "Equity",
                'section_id' => 2,
                'group_id'   => 5,
                'style'      => "bold",
                'subs'       => [
                    "Share capital",
                    "Capital premium",
                    "Other reserves",
                    "Retained earnings",
                    "Minority interest"
                ]
            ],

            //---- Non-current liabilities ------
            [
                'label'      => "Non-current liabilities",
                'section_id' => 2,
                'group_id'   => 6,
                'style'      => "bold",
                'subs'       => [
                    "Shareholder loans",
                    "Interest bearing",
                    "Non-interest bearing",
                    "Loans and borrowings",
                    "Creditors",
                    "Trade creditors",
                    "Player creditors",
                    "Deferred tax liability",
                    "Tax and social contributions",
                    "Accruals and deferred income",
                    "Lease liabilities",
                    "Provisions",
                    "Other non-current liabilities",
                ]
            ],

            //---- Current liabilities ------
            [
                'label'      => "Current liabilities",
                'section_id' => 2,
                'group_id'   => 7,
                'style'      => "bold",
                'subs'       => [
                    "Shareholder loans",
                    "Interest bearing",
                    "Non-interest bearing",
                    "Loans and borrowings",
                    "Creditors",
                    "Trade creditors",
                    "Player creditors",
                    "Tax and social contributions",
                    "Accruals and deferred income",
                    "Lease liabilities",
                    "Provisions",
                    "Other current liabilities",
                ]
            ],


            // Third section (CF)
            //---- A) Net Cash from Operating Activities ------
            [
                'label'      => "",
                'section_id' => 3,
                'group_id'   => 1,
                'style'      => "bold",
                'subs'       => [
                    "Profit/(Loss) after taxation",
                    "-/+ gains/(losses) on player sales",
                    "+/- Amortisation & Depreciation",
                    "Loss/(profit) on sale of tangible assets",
                    "Net finance income",
                    "Taxation expense/(credit)",
                    "Accrued (income)/expenses",
                    "TV & broadcasting rebate",
                    "Decrease/(increase) in debtors",
                    "Decrease/(increase) in stocks",
                    "(Decrease)/increase in creditors",
                    "Decrease/(increase) in other current assets",
                    "(Decrease)/increase in other current liabilities",
                    "Non-cash movement",
                    "A) Net Cash from Operating Activities"
                ]
            ],

            //---- B) Net Cash from Investing Activities ------
            [
                'label'      => "",
                'section_id' => 3,
                'group_id'   => 2,
                'style'      => "bold",
                'subs'       => [
                    "Change in fixed assets",
                    "Change in player registrations",
                    "Finance Income",
                    "B) Net Cash from Investing Activities"
                ]
            ],

            //---- C) Net Cash from Funding Activities ------
            [
                'label'      => "",
                'section_id' => 3,
                'group_id'   => 3,
                'style'      => "bold",
                'subs'       => [
                    "New Loans - external",
                    "Repayment of loans - external",
                    "New Loans - shareholder",
                    "Repayment of loans - shareholder",
                    "Capital contributions paid in/paid out",
                    "Financial expense",
                    "Capital element of finance lease repaid",
                    "Dividends paid",
                    "C) Net Cash from Funding Activities"
                ]
            ],

            //---- Net Cash Flow ------
            [
                'label'      => "Net Cash Flow",
                'section_id' => 3,
                'group_id'   => 4,
                'style'      => "bold",
                'subs'       => [
                    "Other - Tax Paid"
                ]
            ],

            [
                'label'      => "Opening cash balance",
                'section_id' => 3,
                'group_id'   => 5,
                'style'      => "bold"
            ],
            [
                'label'      => "Closing cash balance",
                'section_id' => 3,
                'group_id'   => 6,
                'style'      => "bold"
            ]
        ];

        foreach ($items as $item) {
            $index = 1;
            if (!empty($item['label'])) {
                app(CreateFinancialItemTask::class)->run([
                    'label'      => $item['label'],
                    'item_slag'  => self::makeSlag($item['label']),
                    'section_id' => $item['section_id'],
                    'group_id'   => $item['group_id'],
                    'index'      => $index,
                    'style'      => $item['style'] ?: ''
                ]);

                ++$index;
            }

            if (!empty($item['subs'])) {
                $style = $item['label'] == "" && $item['style'] == "bold" ? "bold" : '';
                $subsCount = count($item['subs']);
                foreach ($item['subs'] as $label) {
                    app(CreateFinancialItemTask::class)->run([
                        'label'      => $label,
                        'item_slag'  => self::makeSlag($label),
                        'section_id' => $item['section_id'],
                        'group_id'   => $item['group_id'],
                        'index'      => $index,
                        'style'      => $index == $subsCount ? $style : ''
                    ]);
                    ++$index;
                }
            }
        }
    }

    private static function makeSlag($label)
    {
        $slag = preg_replace("/[^\w]/", "-", strtolower(trim($label)));
        return preg_replace("/-+/", "-", trim($slag, '-'));
    }
}
