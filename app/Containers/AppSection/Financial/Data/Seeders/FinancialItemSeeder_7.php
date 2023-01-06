<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\CreateFinancialItemTask;
use App\Ship\Parents\Seeders\Seeder;

class FinancialItemSeeder_7 extends Seeder
{
    public function run()
    {
        \DB::table('financial_items')->delete();

        $somefinancialItems = [
            // First section
            [
                'label' => 'Total operating revenue',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Matchday',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 2,
                'style' => ''
            ],
            [
                'label' => 'Broadcasting',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => 'Comercial',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 4,
                'style' => ''
            ],
            [
                'label' => 'Other',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 5,
                'style' => ''
            ],

            [
                'label' => 'Operating expenses',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Staff costs',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 2,
                'style' => ''
            ],
            [
                'label' => 'Other operational costs',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => "Operating Profit/(Loss)",
                'section_id' => 1,
                'group_id' => 3,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Player trading',
                'section_id' => 1,
                'group_id' => 4,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => "Revenues/(costs) associated with Player loans",
                'section_id' => 1,
                'group_id' => 4,
                'index' => 2,
                'style' => ''
            ],
            [
                'label' => 'Profit/(loss) on Player sales',
                'section_id' => 1,
                'group_id' => 4,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => "Amortisation of Players' registrations",
                'section_id' => 1,
                'group_id' => 4,
                'index' => 4,
                'style' => ''
            ],
            [
                'label' => "Impairment of Players' registrations",
                'section_id' => 1,
                'group_id' => 4,
                'index' => 5,
                'style' => ''
            ],
            [
                'label' => 'Earnings before interest and tax (EBIT)',
                'section_id' => 1,
                'group_id' => 5,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Net Finance Income / Cost',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Finance Income',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 2,
                'style' => ''
            ],
            [
                'label' => 'Finance Cost',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => 'Net Non-operating Income / Costs',
                'section_id' => 1,
                'group_id' => 7,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Pre-tax Profit/Loss',
                'section_id' => 1,
                'group_id' => 8,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Tax',
                'section_id' => 1,
                'group_id' => 9,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Profit/loss after tax',
                'section_id' => 1,
                'group_id' => 10,
                'index' => 1,
                'style' => 'bold'
            ],

            // Second section
            [
                'label' => 'Total Assets:',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => '1. Non-current assets',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 2,
                'style' => 'bold'
            ],
            [
                'label' => 'Properties and facilities',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => "Players' registrations",
                'section_id' => 2,
                'group_id' => 1,
                'index' => 4,
                'style' => ''
            ],
            [
                'label' => 'Goodwill',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 5,
                'style' => ''
            ],
            [
                'label' => 'Debtors',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 6,
                'style' => ''
            ],
            [
                'label' => '1. Player debtors',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 7,
                'style' => ''
            ],
            [
                'label' => '2. Trade debtors',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 8,
                'style' => ''
            ],
            [
                'label' => 'Right of use assets (lease)',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 9,
                'style' => ''
            ],
            [
                'label' => 'Investments',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 10,
                'style' => ''
            ],
            [
                'label' => 'Deferred tax',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 11,
                'style' => ''
            ],
            [
                'label' => 'Derivative financial instruments',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 12,
                'style' => ''
            ],
            [
                'label' => 'Other non-current assets',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 13,
                'style' => ''
            ],
            [
                'label' => '2. Current assets',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 14,
                'style' => 'bold'
            ],
            [
                'label' => 'Cash and cash equivalents',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 15,
                'style' => ''
            ],
            [
                'label' => 'Stock/inventory',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 16,
                'style' => ''
            ],
            [
                'label' => 'Debtors',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 17,
                'style' => ''
            ],
            [
                'label' => '1. Trade debtors',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 18,
                'style' => ''
            ],
            [
                'label' => '2. Player debtors',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 19,
                'style' => ''
            ],
            [
                'label' => 'Prepayments & Acrrued Revenue',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 20,
                'style' => ''
            ],
            [
                'label' => 'Other current assets',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 21,
                'style' => ''
            ],

            [
                'label' => 'Total Liabilities:',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => '1. Equity',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 2,
                'style' => 'bold'
            ],
            [
                'label' => 'Share capital',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => 'Capital premium',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 4,
                'style' => ''
            ],
            [
                'label' => 'Other reserves',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 5,
                'style' => ''
            ],
            [

                'label' => 'Retained earnings',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 6,
                'style' => ''
            ],
            [
                'label' => 'Minority Interest',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 7,
                'style' => ''
            ],

            [
                'label' => '2. Non-current liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 8,
                'style' => 'bold'
            ],
            [

                'label' => 'Shareholders loans',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 9,
                'style' => ''
            ],
            [

                'label' => '1. Interest bearing',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 10,
                'style' => ''
            ],
            [
                'label' => '2. Non-interest bearing',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 11,
                'style' => ''
            ],
            [

                'label' => 'Loans and borrowing',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 12,
                'style' => ''
            ],
            [
                'label' => 'Creditors',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 13,
                'style' => ''
            ],
            [
                'label' => '1. Trade creditors',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 14,
                'style' => ''
            ],
            [
                'label' => '2. Player creditors',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 15,
                'style' => ''
            ],
            [
                'label' => 'Defered tax liability',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 16,
                'style' => ''
            ],
            [
                'label' => 'Tax and Social Contributions',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 17,
                'style' => ''
            ],
            [
                'label' => 'Accruals and deferred income',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 18,
                'style' => ''
            ],
            [
                'label' => 'Lease liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 19,
                'style' => ''
            ],
            [
                'label' => 'Other non-current liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 20,
                'style' => ''
            ],
            [
                'label' => '3. Current liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 21,
                'style' => 'bold'
            ],
            [

                'label' => 'Shareholders loans',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 22,
                'style' => ''
            ],
            [
                'label' => '1. Interest bearing',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 23,
                'style' => ''
            ],
            [
                'label' => '2. Non-interest bearing',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 24,
                'style' => ''
            ],
            [
                'label' => 'Loans and borrowing',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 25,
                'style' => ''
            ],
            [
                'label' => 'Creditors',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 26,
                'style' => ''
            ],
            [
                'label' => '1. Trade creditors',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 27,
                'style' => ''
            ],
            [
                'label' => '2. Player creditors',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 28,
                'style' => ''
            ],
            [
                'label' => 'Tax and Social Contributions',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 29,
                'style' => ''
            ],
            [
                'label' => 'Accruals and deferred revenue',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 30,
                'style' => ''
            ],
            [
                'label' => 'Lease liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 31,
                'style' => ''
            ],
            [
                'label' => 'Other current liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 32,
                'style' => ''
            ],
            [
                'label' => 'Debt Structure',
                'section_id' => 2,
                'group_id' => 3,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Net Loans & borrowings',
                'section_id' => 2,
                'group_id' => 3,
                'index' => 2,
                'style' => ''
            ],
            [
                'label' => 'Net Transfer debt',
                'section_id' => 2,
                'group_id' => 3,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => 'Non-current Tax and Social Contributions',
                'section_id' => 2,
                'group_id' => 3,
                'index' => 4,
                'style' => ''
            ],
            [
                'label' => 'Shareholder debt',
                'section_id' => 2,
                'group_id' => 3,
                'index' => 5,
                'style' => ''
            ],
            [
                'label' => 'Squad Valuation',
                'section_id' => 2,
                'group_id' => 4,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Book value',
                'section_id' => 2,
                'group_id' => 4,
                'index' => 1,
                'style' => ''
            ],
            [
                'label' => 'Market value**',
                'section_id' => 2,
                'group_id' => 4,
                'index' => 2,
                'style' => ''
            ],


            // Third section
            [
                'label' => 'Profit/(Loss) before taxation',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 1,
                'style' => ''
            ],
            [
                'label' => '-/+ gains/(losses) on Player Sales',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 2,
                'style' => ''
            ],
            [
                'label' => '+/- Amortisation & Depreciation',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => 'Loss/(profit) on sale of tangible assets',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 4,
                'style' => ''
            ],
            [
                'label' => 'Net finance income',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 5,
                'style' => ''
            ],
            [
                'label' => 'Accrued (income)/expenses',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 6,
                'style' => ''
            ],
            [
                'label' => 'TV & broadcasting rebate',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 7,
                'style' => ''
            ],
            [
                'label' => 'Decrease/(increase) in debtors',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 8,
                'style' => ''
            ],
            [
                'label' => 'Decrease/(increase) in stocks',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 9,
                'style' => ''
            ],
            [
                'label' => '(Decrease)/increase in creditors',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 10,
                'style' => ''
            ],
            [
                'label' => 'Decrease/(increase) in other current Assets',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 11,
                'style' => ''
            ],
            [
                'label' => '(Decrease)/increase in other current liabilities',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 12,
                'style' => ''
            ],
            [
                'label' => 'Other Non Cash movements',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 13,
                'style' => ''
            ],
            [
                'label' => 'A) Net Cash from Operating Activities',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 14,
                'style' => 'bold'
            ],
            [
                'label' => 'Change in fixed assets',
                'section_id' => 3,
                'group_id' => 2,
                'index' => 1,
                'style' => ''
            ],
            [
                'label' => 'Change in player registrations',
                'section_id' => 3,
                'group_id' => 2,
                'index' => 2,
                'style' => ''
            ],
            [
                'label' => "Finance Income",
                'section_id' => 3,
                'group_id' => 2,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => 'B) Net Cash from Investing Activities',
                'section_id' => 3,
                'group_id' => 2,
                'index' => 4,
                'style' => 'bold'
            ],
            [
                'label' => 'New Loans - external',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Repayment of loans - external',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 2,
                'style' => ''
            ],
            [
                'label' => 'New Loans - Shareholder',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 3,
                'style' => ''
            ],
            [
                'label' => 'Repayment of loans - Shareholder',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 4,
                'style' => ''
            ],
            [
                'label' => 'Capital contributions paid in/paid out',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 5,
                'style' => ''
            ],
            [
                'label' => 'Financial expense',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 6,
                'style' => ''
            ],
            [
                'label' => "Capital element of finance lease repaid",
                'section_id' => 3,
                'group_id' => 3,
                'index' => 7,
                'style' => ''
            ],
            [
                'label' => 'Dividends Paid',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 8,
                'style' => ''
            ],
            [
                'label' => 'C) Net Cash from Funding Activities',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 9,
                'style' => 'bold'
            ],
            [
                'label' => 'D) Tax Paid',
                'section_id' => 3,
                'group_id' => 4,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Net Cash Flow',
                'section_id' => 3,
                'group_id' => 5,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Other Non-cash impact',
                'section_id' => 3,
                'group_id' => 6,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Opening cash balance',
                'section_id' => 3,
                'group_id' => 7,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                'label' => 'Closing cash balance',
                'section_id' => 3,
                'group_id' => 8,
                'index' => 1,
                'style' => 'bold'
            ]
        ];

        foreach ($somefinancialItems as $financialItem) {
            app(CreateFinancialItemTask::class)->run($financialItem);
        }
    }
}
