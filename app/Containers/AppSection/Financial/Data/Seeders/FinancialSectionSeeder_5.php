<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\CreateFinancialSectionTask;
use App\Ship\Parents\Seeders\Seeder;

class FinancialSectionSeeder_5 extends Seeder
{
    public function run()
    {
        \DB::table('financial_sections')->delete();

        $financialSections = [
            [
                'id' => 1,
                'label' => 'Profit/loss sheet',
                'index' => 1,
                'nb_years' => 3
            ],
            [
                'id' => 2,
                'label' => 'Balance sheet',
                'index' => 2,
                'nb_years' => 3
            ],
            [
                'id' => 3,
                'label' => 'Cash flow',
                'index' => 3,
                'nb_years' => 3
            ],
        ];

        foreach ($financialSections as $financialSection) {
            app(CreateFinancialSectionTask::class)->run($financialSection);
        }
    }
}
