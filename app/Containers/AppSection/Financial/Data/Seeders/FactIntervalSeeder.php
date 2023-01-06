<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\CreateFactIntervalTask;
use App\Ship\Parents\Seeders\Seeder;

class FactIntervalSeeder extends Seeder
{
    public function run()
    {
        \DB::table('fact_intervals')->delete();

        $intervals = ['2020/21', '2019/20', '2018/19', '2017/18'];

        $i = 1;
        foreach ($intervals as $interval) {
            app(CreateFactIntervalTask::class)->run(['id' => $i, 'interval' => $interval]);
            ++$i;
        }
    }
}
