<?php

namespace App\Containers\AppSection\System\Data\Seeders;

use App\Containers\AppSection\System\Tasks\CreateBorrowerTypeTask;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Ship\Parents\Seeders\Seeder;

class BorrowerTypeSeeder extends Seeder
{
    public function run()
    {
        \DB::table('borrower_types')->delete();

        $borrower_types = [
            [
                'id' => BorrowerType::getId(BorrowerType::FINANCIAL_MANAGER),
                'name' => BorrowerType::FINANCIAL_MANAGER,
                'type' => BorrowerType::AGENT,
                'index' => 6,
            ],
            [
                'id' => BorrowerType::getId(BorrowerType::PROFESSIONAL_ATHLETE),
                'name' => BorrowerType::PROFESSIONAL_ATHLETE,
                'type' => BorrowerType::ATHLETE,
                'index' => 2,
            ],
            [
                'id' => BorrowerType::getId(BorrowerType::SPORTS_AGENT),
                'name' => BorrowerType::SPORTS_AGENT,
                'type' => BorrowerType::AGENT,
                'index' => 4,
            ],
            [
                'id' => BorrowerType::getId(BorrowerType::SPORTS_LAWYER),
                'name' => BorrowerType::SPORTS_LAWYER,
                'type' => BorrowerType::AGENT,
                'index' => 5,
            ],
            [
                'id' => BorrowerType::getId(BorrowerType::SPORTS_ORGANIZATION),
                'name' => BorrowerType::SPORTS_ORGANIZATION,
                'type' => BorrowerType::CORPORATE,
                'index' => 1,
            ],
            [
                'id' => BorrowerType::getId(BorrowerType::SPORTS_MARKETING_AGENCY),
                'name' => BorrowerType::SPORTS_MARKETING_AGENCY,
                'type' => BorrowerType::AGENT,
                'index' => 7,
            ],
            [
                'id' => BorrowerType::getId(BorrowerType::PROFESSIONAL_COACH),
                'name' => BorrowerType::PROFESSIONAL_COACH,
                'type' => BorrowerType::ATHLETE,
                'index' => 3,
            ]
        ];

        foreach ($borrower_types as $borrower_type) {
            app(CreateBorrowerTypeTask::class)->run($borrower_type, true);
        }
    }
}
