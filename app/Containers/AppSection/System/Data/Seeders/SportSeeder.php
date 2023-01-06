<?php

namespace App\Containers\AppSection\System\Data\Seeders;

use App\Containers\AppSection\System\Tasks\CreateSportTask;
use App\Ship\Parents\Seeders\Seeder;

class SportSeeder extends Seeder
{
    public function run()
    {
        \DB::table('sports')->delete();

        // SEEMEk: do not change the order if you add a new sport
        $sports_name = [
            [
                'id' => 1,
                'name' => 'Football',
                'is_active' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Rugby League',
                'is_active' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Rugby Union',
                'is_active' => 1,
            ],
            [
                'id' => 4,
                'name' => 'Tennis',
                'is_active' => 1,
            ],
            [
                'id' => 5,
                'name' => 'Formula 1',
                'is_active' => 1,
            ],
            [
                'id' => 6,
                'name' => 'Golf',
                'is_active' => 1,
            ],
            [
                'id' => 7,
                'name' => 'Athletics',
                'is_active' => 1,
            ],
            [
                'id' => 8,
                'name' => 'NFL',
                'is_active' => 1,
            ],
            [
                'id' => 9,
                'name' => 'NBA',
                'is_active' => 1,
            ],
            [
                'id' => 10,
                'name' => 'MLB',
                'is_active' => 1,
            ],
            [
                'id' => 11,
                'name' => 'NHL',
                'is_active' => 1,
            ],
            [
                'id' => 12,
                'name' => 'Snooker',
                'is_active' => 1,
            ],
            [
                'id' => 13,
                'name' => 'Darts',
                'is_active' => 1,
            ],
            [
                'id' => 14,
                'name' => 'UFC',
                'is_active' => 1,
            ],
            [
                'id' => 15,
                'name' => 'Cricket',
                'is_active' => 1,
            ],
            [
                'id' => 16,
                'name' => 'Horse Racing',
                'is_active' => 1,
            ],
            [
                'id' => 17,
                'name' => 'Esports',
                'is_active' => 1,
            ],
            [
                'id' => 18,
                'name' => 'Boxing',
                'is_active' => 1,
            ],
            [
                'id' => 20,
                'name' => 'Other',
                'is_active' => 0,
            ],
        ];

        foreach ($sports_name as $row) {
            app(CreateSportTask::class)->run($row['id'], $row['name'], $row['is_active']);
        }
    }
}
