<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\CreateFinancialItemTask;
use App\Ship\Parents\Seeders\Seeder;

class FinancialItemSeeder_6 extends Seeder
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
                 
                'label' => 'Total operating expenses',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'Staff costs',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 2,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'Wages and salaries',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 3,
                'style' => ''
            ],
            [
                 
                'label' => 'Social security costs',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 4,
                'style' => ''
            ],
            [
                 
                'label' => 'Other pension costs',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 5,
                'style' => ''
            ],
            [
                 
                'label' => 'Other staff costs',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 5,
                'style' => ''
            ],
            [
                 
                'label' => 'Other operating expenses',
                'section_id' => 1,
                'group_id' => 6,
                'index' => 6,
                'style' => ''
            ],
            [
                 
                'label' => "Profit/Loss before player trading and amortization of players' registrations & depreciation (EBITDA)",
                'section_id' => 1,
                'group_id' => 8,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'Depreciation',
                'section_id' => 1,
                'group_id' => 8,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => "Profit/Loss before player trading and amortization of players' registrations",
                'section_id' => 1,
                'group_id' => 9,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => "Profit/Loss on disposal of players' registrations",
                'section_id' => 1,
                'group_id' => 9,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => 'Other revenue/costs associated to players',
                'section_id' => 1,
                'group_id' => 9,
                'index' => 3,
                'style' => ''
            ],
            [
                 
                'label' => "Amortisation of players' registrations",
                'section_id' => 1,
                'group_id' => 9,
                'index' => 4,
                'style' => ''
            ],
            [
                 
                'label' => "Impairment of players' registrations",
                'section_id' => 1,
                'group_id' => 9,
                'index' => 5,
                'style' => ''
            ],
            [
                 
                'label' => 'Total player trading',
                'section_id' => 1,
                'group_id' => 9,
                'index' => 6,
                'style' => ''
            ],
            [
                 
                'label' => 'Profit on ordinary activities before interest and tax (EBIT)',
                'section_id' => 1,
                'group_id' => 15,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'Net Total Interest receivable/payable',
                'section_id' => 1,
                'group_id' => 15,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => 'Interest receivable and similar income',
                'section_id' => 1,
                'group_id' => 15,
                'index' => 3,
                'style' => ''
            ],
            [
                 
                'label' => 'Interest payable and similar charges',
                'section_id' => 1,
                'group_id' => 15,
                'index' => 4,
                'style' => ''
            ],
            [
                 
                'label' => 'Net Total Extraordinary Income/(Expenses)',
                'section_id' => 1,
                'group_id' => 15,
                'index' => 5,
                'style' => ''
            ],
            [
                 
                'label' => 'Pre-tax Profit/Loss',
                'section_id' => 1,
                'group_id' => 18,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'Tax',
                'section_id' => 1,
                'group_id' => 18,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => 'Profit after tax',
                'section_id' => 1,
                'group_id' => 20,
                'index' => 1,
                'style' => 'bold'
            ],
            // Second section
            [
                 
                'label' => 'Total assests',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'Current assets',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => 'Cash and cash equivalents',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 3,
                'style' => ''
            ],
            [
                 
                'label' => 'Stock/Inventory',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 4,
                'style' => ''
            ],
            [
                 
                'label' => 'Debtors',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 6,
                'style' => ''
            ],
            [
                 
                'label' => 'Prepayments and accrued income',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 8,
                'style' => ''
            ],
            [
                 
                'label' => 'Other current assets',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 9,
                'style' => ''
            ],
            [
                 
                'label' => 'Fixed assets',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 10,
                'style' => ''
            ],
            [
                 
                'label' => 'Properties and facilities',
                'section_id' => 2,
                'group_id' => 3,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => "Players' registrations",
                'section_id' => 2,
                'group_id' => 2,
                'index' => 13,
                'style' => ''
            ],
            [
                 
                'label' => "Other fixed assets",
                'section_id' => 2,
                'group_id' => 2,
                'index' => 14,
                'style' => ''
            ],
            [
                 
                'label' => "Total liabilities and shareholders' funds",
                'section_id' => 2,
                'group_id' => 5,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'Current liabilities',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => 'Current loans and borrowing - interest bearing',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 3,
                'style' => ''
            ],
            [
                 
                'label' => 'Current loans and borrowing - intercompany (non-interest)',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 4,
                'style' => ''
            ],
            [
                 
                'label' => 'Total current loans and borrowing',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 5,
                'style' => ''
            ],
            [
                 
                'label' => 'Current trade creditors',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 6,
                'style' => ''
            ],
            [
                 
                'label' => 'Current tax and social contributions',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 10,
                'style' => ''
            ],
            [
                 
                'label' => 'Current accruals and deferred income',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 11,
                'style' => ''
            ],
            [
                 
                'label' => 'Other current liabilities',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 12,
                'style' => ''
            ],
            [
                 
                'label' => 'Long-term liabilities',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 13,
                'style' => ''
            ],
            [
                 
                'label' => 'Long-term loans and borrowing - interest bearing',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => 'Long-term loans and borrowing - intercompany (non-interest)',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 15,
                'style' => ''
            ],
            [
                 
                'label' => 'Total long-term loans and borrowing',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 17,
                'style' => ''
            ],
            [
                 
                'label' => 'Long-term trade creditors',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 18,
                'style' => ''
            ],
            [
                 
                'label' => 'Long-term tax and social contributions',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 19,
                'style' => ''
            ],
            [
                 
                'label' => 'Long-term accruals and deferred income',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 20,
                'style' => ''
            ],
            [
                 
                'label' => 'Long-term provisions for liabilities and charges',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 22,
                'style' => ''
            ],
            [
                 
                'label' => 'Other long-term liabilities',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 23,
                'style' => ''
            ],
            [
                 
                'label' => 'Retained earnings',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 24,
                'style' => ''
            ],
            [
                 
                'label' => 'Equity',
                'section_id' => 2,
                'group_id' => 5,
                'index' => 25,
                'style' => ''
            ],
            [
                 
                'label' => "Shareholders' funds",
                'section_id' => 2,
                'group_id' => 5,
                'index' => 30,
                'style' => ''
            ],
            // Third section
            [
                 
                'label' => 'Net Loss',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => '+/- change in provisions and write downs',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => '+/- gains/(losses) on disposal of players',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 3,
                'style' => ''
            ],
            [
                 
                'label' => '+/- Amortisation & Depreciation',
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
                 
                'label' => 'Other non-monetary variations',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 6,
                'style' => ''
            ],
            [
                 
                'label' => 'Change in Debtors/Receivables',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 7,
                'style' => ''
            ],
            [
                 
                'label' => 'Change in Stock/Inventory',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 8,
                'style' => ''
            ],
            [
                 
                'label' => 'Changes in tax receivables',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 9,
                'style' => ''
            ],
            [
                 
                'label' => 'Change in Other Current Assets',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 10,
                'style' => ''
            ],
            [
                 
                'label' => 'Changes in Other Non Current Assets',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 11,
                'style' => ''
            ],
            [
                 
                'label' => 'Changes in provisions for risk and charges',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 12,
                'style' => ''
            ],
            [
                 
                'label' => 'Change in Trade Creditors',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 13,
                'style' => ''
            ],
            [
                 
                'label' => 'Change in tax payables',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 14,
                'style' => ''
            ],
            [
                 
                'label' => 'Change in Other Current Liabilities',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 15,
                'style' => ''
            ],
            [
                 
                'label' => 'Change in Other non current liabilities',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 16,
                'style' => ''
            ],
            [
                 
                'label' => 'Tax payments',
                'section_id' => 3,
                'group_id' => 1,
                'index' => 17,
                'style' => ''
            ],
            [
                 
                'label' => 'Net Cash from Operating Activities',
                'section_id' => 3,
                'group_id' => 2,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'Investment in Player Registeration rights',
                'section_id' => 3,
                'group_id' => 2,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => "Disposal of players' registeration rights",
                'section_id' => 3,
                'group_id' => 2,
                'index' => 3,
                'style' => ''
            ],
            [
                 
                'label' => 'Changes in receivables related to player registerations',
                'section_id' => 3,
                'group_id' => 2,
                'index' => 4,
                'style' => ''
            ],
            [
                 
                'label' => 'Changes in payables related to player registerations',
                'section_id' => 3,
                'group_id' => 2,
                'index' => 5,
                'style' => ''
            ],
            [
                 
                'label' => 'Change in other tangible and intangible assets',
                'section_id' => 3,
                'group_id' => 2,
                'index' => 6,
                'style' => ''
            ],
            [
                 
                'label' => 'Net Cash from Investing Activities',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'New Loans',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 2,
                'style' => ''
            ],
            [
                 
                'label' => 'Repayment of Loans',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 3,
                'style' => ''
            ],
            [
                 
                'label' => 'Financial expenses',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 4,
                'style' => ''
            ],
            [
                 
                'label' => 'Release excess funds from secured account',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 5,
                'style' => ''
            ],
            [
                 
                'label' => 'Payments related to rights of use',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 6,
                'style' => ''
            ],
            [
                 
                'label' => "Payments in shareholder's loan",
                'section_id' => 3,
                'group_id' => 3,
                'index' => 7,
                'style' => ''
            ],
            [
                 
                'label' => 'Capital contribution paid in by shareholders for future capital increase',
                'section_id' => 3,
                'group_id' => 3,
                'index' => 8,
                'style' => ''
            ],
            [
                 
                'label' => 'Net Cash from Funding Activities',
                'section_id' => 3,
                'group_id' => 4,
                'index' => 1,
                'style' => 'bold'
            ],
            [
                 
                'label' => 'Total Cash Flow',
                'section_id' => 3,
                'group_id' => 5,
                'index' => 1,
                'style' => 'bold'
            ],
        ];


        //Add intial items
        $financialItems = [];

        for($i=0;$i<count($somefinancialItems);$i++){
            $financialItem = $somefinancialItems[$i];
            $financialItem['id'] = $i + 1;
            $financialItems[] = $financialItem;
        }


        //Add items from the template
        $otherFinancialItems = [
            // -------------------------------- Sheet 0----------------------------------------
            [                 
                'label' => 'Total operating revenue (A)',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 1,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Broadcasting revenue (A_2)',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 2,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Commercial revenue (A_3)',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 3,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Matchday revenue (A_1)',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 4,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Total operating expenses (B)',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 5,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Other costs (B_2)',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 6,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Staff costs (B_1)',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 7,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Profit/loss before player trading (C=A-B)',
                'section_id' => 1,
                'group_id' => 1,
                'index' => 8,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Total player trading (D)',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 1,
                'style' => 'bold'
            ],
            [                 
                'label' => "Amortisation of players' registrations (D_3)",
                'section_id' => 1,
                'group_id' => 2,
                'index' => 2,
                'style' => 'bold'
            ],
            [                 
                'label' => "Impairment of players' registrations (D_4)",
                'section_id' => 1,
                'group_id' => 2,
                'index' => 3,
                'style' => 'bold'
            ],
            [                 
                'label' => "Profit/loss on disposal of players' registrations (D_2)",
                'section_id' => 1,
                'group_id' => 2,
                'index' => 4,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Revenues and costs associated to player loans (D_1)',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 5,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Earnings before interest and tax (EBIT) (E=C+D)',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 6,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Net Total interest receivable/payable (F)',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 7,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Net Total Extraordinary Income/Expenses (G)',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 8,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Pre-tax profit/loss (H=E+F+G)',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 9,
                'style' => 'bold'
            ],
            [                 
                'label' => 'Tax (I)',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 10,
                'style' => 'bold'            
            ],
            [                 
                'label' => 'Profit/loss after tax (J=H+I)',
                'section_id' => 1,
                'group_id' => 2,
                'index' => 11,
                'style' => 'bold'
            ],

            // -------------------------------- Sheet 1----------------------------------------
            [                 
                'label' => 'TOTAL ASSETS',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 1,
                'style' => 'bold'
            ],
            [                 
                'label' => '1. Current assets',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 2,
                'style' => 'bold'
            ],
            [                 
                'label' => '1. Cash and cash equivalents',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 3,
                'style' => 'bold'
            ],
            [                 
                'label' => '2. Stock/Inventory',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 4,
                'style' => 'bold'
            ],
            [                 
                'label' => '3. Debtors',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 5,
                'style' => 'bold'
            ],
            [                 
                'label' => '4. Prepayments and accrued income',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 6,
                'style' => 'bold'
            ],
            [                 
                'label' => '5. Other current assets',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 7,
                'style' => 'bold'
            ],
            [                 
                'label' => '2. Fixed assets',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 8,
                'style' => 'bold'
            ],
            [                 
                'label' => '1. Properties and facilities',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 9,
                'style' => 'bold'
            ],
            [
                'label' => "2. Players' registrations",
                'section_id' => 2,
                'group_id' => 1,
                'index' => 10,
                'style' => 'bold'
            ],
            [                 
                'label' => '3. Other fixed assets',
                'section_id' => 2,
                'group_id' => 1,
                'index' => 11,
                'style' => 'bold'
            ],
            [                 
                'label' => 'TOTAL LIABILITIES',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 1,
                'style' => 'bold'
            ],
            [                 
                'label' => '1. Current liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 2,
                'style' => 'bold'
            ],
            [                 
                'label' => '1. Current loans and borrowing - interest bearing',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 3,
                'style' => 'bold'
            ],
            [                 
                'label' => '2. Current loans and borrowing - intercompany',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 4,
                'style' => 'bold'
            ],
            [                 
                'label' => '3. Current trade creditors',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 5,
                'style' => 'bold'
            ],
            [                 
                'label' => '4. Current tax and social contributions',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 6,
                'style' => 'bold'
            ],
            [                 
                'label' => '5. Current accruals and deferred income',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 7,
                'style' => 'bold'
            ],
            [                 
                'label' => '6. Other current liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 8,
                'style' => 'bold'
            ],
            [                 
                'label' => '2. Long-term liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 9,
                'style' => 'bold'
            ],
            [                 
                'label' => '1. Long-term loans and borrowing - interest bearing',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 10,
                'style' => 'bold'
            ],
            [                 
                'label' => '2. Long-term loans and borrowing - intercompany',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 11,
                'style' => 'bold'
            ],
            [                 
                'label' => '3. Long-term trade creditors',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 12,
                'style' => 'bold'
            ],
            [                 
                'label' => '4. Long-term tax and social contributions',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 13,
                'style' => 'bold'
            ],
            [                 
                'label' => '5. Long-term accruals and deferred income',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 14,
                'style' => 'bold'
            ],
            [                 
                'label' => '6. Long-term provisions for liabilities and charges',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 15,
                'style' => 'bold'
            ],
            [                 
                'label' => '7. Other long-term liabilities',
                'section_id' => 2,
                'group_id' => 2,
                'index' => 16,
                'style' => 'bold'
            ],
            [                 
                'label' => '3. Equity',
                'section_id' => 2,
                'group_id' => 3,
                'index' => 1,
                'style' => 'bold'
            ],
            [                 
                'label' => "Shareholders' funds",
                'section_id' => 2,
                'group_id' => 3,
                'index' => 2,
                'style' => 'bold'
            ]
        ];

        for($j=0;$j<count($otherFinancialItems);$j++){
            $otherFinancialItem = $otherFinancialItems[$j];
            $otherFinancialItem['id'] = count($somefinancialItems) + $j + 1;
            $financialItems[] = $otherFinancialItem;
        }


        foreach ($financialItems as $financialItem) {
            app(CreateFinancialItemTask::class)->run($financialItem);
        }
    }
}
