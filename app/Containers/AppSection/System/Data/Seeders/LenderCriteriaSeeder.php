<?php

namespace App\Containers\AppSection\System\Data\Seeders;

use App\Containers\AppSection\System\Enums\Currency;
use App\Containers\AppSection\System\Enums\LenderCriteriaType;
use App\Containers\AppSection\System\Tasks\CreateLenderCriteriaTask;
use App\Containers\AppSection\System\Tasks\CreateTvRightsHolderTask;
use App\Ship\Parents\Seeders\Seeder;

class LenderCriteriaSeeder extends Seeder
{
    public function run()
    {
        \DB::table('lender_criteria')->delete();

        $lender_criteria = [
            [
                'id' => 1,
                'type' => LenderCriteriaType::LENDER_TYPE,
                'value' => 'Bank',
                'index' => 1
            ],
            [
                'id' => 2,
                'type' => LenderCriteriaType::LENDER_TYPE,
                'value' => 'Private Credit Fund',
                'index' => 2
            ],
            [
                'id' => 3,
                'type' => LenderCriteriaType::LENDER_TYPE,
                'value' => 'Family Office',
                'index' => 3
            ],
            [
                'id' => 4,
                'type' => LenderCriteriaType::DEAL_TYPE,
                'value' => 'Player Transfer',
                'index' => 1
            ],
            [
                'id' => 5,
                'type' => LenderCriteriaType::DEAL_TYPE,
                'value' => 'TV/Media Rights',
                'index' => 3
            ],
            [
                'id' => 6,
                'type' => LenderCriteriaType::DEAL_TYPE,
                'value' => 'Endorsement Deals',
                'index' => 4
            ],
            [
                'id' => 7,
                'type' => LenderCriteriaType::DEAL_TYPE,
                'value' => 'Players Contracts',
                'index' => 2
            ],
            [
                'id' => 8,
                'type' => LenderCriteriaType::DEAL_TYPE,
                'value' => 'Agent Fees',
                'index' => 5
            ],
            [
                'id' => 9,
                'type' => LenderCriteriaType::CURRENCY,
                'value' => Currency::EUR,
                'index' => 1
            ],
            [
                'id' => 10,
                'type' => LenderCriteriaType::CURRENCY,
                'value' => Currency::GBP,
                'index' => 2
            ],
            [
                'id' => 11,
                'type' => LenderCriteriaType::CURRENCY,
                'value' => Currency::USD,
                'index' => 3
            ],
            [
                'id' => 12,
                'type' => LenderCriteriaType::MIN_AMOUNT,
                'value' => '250.000k-5m',
                'index' => 1
            ],
            [
                'id' => 13,
                'type' => LenderCriteriaType::MIN_AMOUNT,
                'value' => '5-10m',
                'index' => 2
            ],
            [
                'id' => 14,
                'type' => LenderCriteriaType::MIN_AMOUNT,
                'value' => '10-20m',
                'index' => 3
            ],
            [
                'id' => 15,
                'type' => LenderCriteriaType::MIN_AMOUNT,
                'value' => ' 25m+',
                'index' => 4
            ],
            [
                'id' => 16,
                'type' => LenderCriteriaType::MAX_AMOUNT,
                'value' => '5m',
                'index' => 1
            ],
            [
                'id' => 17,
                'type' => LenderCriteriaType::MAX_AMOUNT,
                'value' => '10m',
                'index' => 2
            ],
            [
                'id' => 18,
                'type' => LenderCriteriaType::MAX_AMOUNT,
                'value' => '20m',
                'index' => 3
            ],
            [
                'id' => 19,
                'type' => LenderCriteriaType::MAX_AMOUNT,
                'value' => '50m',
                'index' => 4
            ],
            [
                'id' => 20,
                'type' => LenderCriteriaType::MAX_AMOUNT,
                'value' => '75m',
                'index' => 5
            ],
            [
                'id' => 21,
                'type' => LenderCriteriaType::MAX_AMOUNT,
                'value' => '100m+',
                'index' => 6
            ],
            [
                'id' => 22,
                'type' => LenderCriteriaType::MIN_TENOR,
                'value' => '3 months',
                'index' => 1
            ],
            [
                'id' => 23,
                'type' => LenderCriteriaType::MIN_TENOR,
                'value' => '6 months',
                'index' => 2
            ],
            [
                'id' => 24,
                'type' => LenderCriteriaType::MIN_TENOR,
                'value' => '12 months',
                'index' => 3
            ],
            [
                'id' => 25,
                'type' => LenderCriteriaType::MIN_TENOR,
                'value' => '18 months',
                'index' => 4
            ],
            [
                'id' => 26,
                'type' => LenderCriteriaType::MIN_TENOR,
                'value' => '24 months',
                'index' => 5
            ],
            [
                'id' => 27,
                'type' => LenderCriteriaType::MAX_TENOR,
                'value' => '2 years',
                'index' => 1
            ],
            [
                'id' => 28,
                'type' => LenderCriteriaType::MAX_TENOR,
                'value' => '4 years',
                'index' => 2
            ],
            [
                'id' => 29,
                'type' => LenderCriteriaType::MAX_TENOR,
                'value' => '6 years',
                'index' => 3
            ],
            [
                'id' => 30,
                'type' => LenderCriteriaType::MAX_TENOR,
                'value' => '8 years',
                'index' => 4
            ],
            [
                'id' => 31,
                'type' => LenderCriteriaType::MAX_TENOR,
                'value' => '10 years',
                'index' => 5
            ],
            [
                'id' => 32,
                'type' => LenderCriteriaType::MAX_TENOR,
                'value' => '15+ years',
                'index' => 6
            ],
            [
                'id' => 33,
                'type' => LenderCriteriaType::MIN_INTEREST,
                'value' => '2',
                'index' => 1
            ],
            [
                'id' => 34,
                'type' => LenderCriteriaType::MIN_INTEREST,
                'value' => '3',
                'index' => 2
            ],
            [
                'id' => 35,
                'type' => LenderCriteriaType::MIN_INTEREST,
                'value' => '4',
                'index' => 3
            ],
            [
                'id' => 36,
                'type' => LenderCriteriaType::MIN_INTEREST,
                'value' => '5',
                'index' => 4
            ],
            [
                'id' => 37,
                'type' => LenderCriteriaType::MIN_INTEREST,
                'value' => '6',
                'index' => 5
            ],
            [
                'id' => 38,
                'type' => LenderCriteriaType::MIN_INTEREST,
                'value' => '7',
                'index' => 6
            ],
            [
                'id' => 39,
                'type' => LenderCriteriaType::MIN_INTEREST,
                'value' => '8',
                'index' => 7
            ],
            [
                'id' => 40,
                'type' => LenderCriteriaType::MIN_INTEREST,
                'value' => '9',
                'index' => 8
            ],
            [
                'id' => 41,
                'type' => LenderCriteriaType::INTEREST_RANGE,
                'value' => '2-4',
                'index' => 1
            ],
            [
                'id' => 42,
                'type' => LenderCriteriaType::INTEREST_RANGE,
                'value' => '3-5',
                'index' => 2
            ],
            [
                'id' => 43,
                'type' => LenderCriteriaType::INTEREST_RANGE,
                'value' => '5-7',
                'index' => 3
            ],
            [
                'id' => 44,
                'type' => LenderCriteriaType::INTEREST_RANGE,
                'value' => '7-10',
                'index' => 4
            ],
        ];

        foreach ($lender_criteria as $row) {
            app(CreateLenderCriteriaTask::class)->run($row);
        }
    }
}
