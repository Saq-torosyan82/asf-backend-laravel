<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\CreateFactNameTask;
use App\Ship\Parents\Seeders\Seeder;

class FactNameSeeder extends Seeder
{
    public function run()
    {
        \DB::table('fact_names')->delete();

        $facts = [
            // 'Official club name',
            // 'Address'
        ];

        $i = 1;
        foreach ($facts as $fact) {
            app(CreateFactNameTask::class)->run(['name' => $fact]);
        }
    }
}
