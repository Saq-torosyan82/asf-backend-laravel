<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\GetFactIntervalsTask;
use App\Containers\AppSection\Financial\Tasks\UpdateFactIntervalTask;
use App\Ship\Parents\Seeders\Seeder;

class FactIntIndexSeeder extends Seeder
{
    public function run()
    {
        $intervals = app(GetFactIntervalsTask::class)->run();
        if (!empty($intervals)) {
            $count = $intervals->count();
            for ($i = $count; $i >= 1; --$i) {
                app(UpdateFactIntervalTask::class)->run($i, ['index' => ($count - $i + 1)] );
            }
        }

    }
}
