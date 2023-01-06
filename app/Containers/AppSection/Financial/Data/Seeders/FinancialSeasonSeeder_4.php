<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\CreateFinancialSeasonTask;
use App\Ship\Parents\Seeders\Seeder;

class FinancialSeasonSeeder_4 extends Seeder
{
    public function run()
    {
        \DB::table('financial_seasons')->delete();

        $financialSeasons = [
            [
                'id' => 1,
                'label' => '17/18',
                'index' => 1,
            ],
            [
                'id' => 2,
                'label' => '18/19',
                'index' => 2,
            ],
            [
                'id' => 3,
                'label' => '19/20',
                'index' => 3,
            ],
            [
                'id' => 4,
                'label' => '20/21',
                'index' => 4,
            ],
            [
                'id' => 5,
                'label' => '21/22',
                'index' => 5,
            ],
        ];

        foreach ($financialSeasons as $financialSeason) {
            app(CreateFinancialSeasonTask::class)->run($financialSeason);
        }
    }
}
