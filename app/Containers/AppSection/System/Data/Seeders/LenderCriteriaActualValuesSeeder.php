<?php

namespace App\Containers\AppSection\System\Data\Seeders;

use App\Containers\AppSection\Deal\Enums\InstallmentFrequency;
use App\Containers\AppSection\System\Enums\LenderCriteriaType;
use App\Ship\Parents\Seeders\Seeder;

use App\Containers\AppSection\System\Tasks\GetLenderCriteriaByTypeTask;

class LenderCriteriaActualValuesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            LenderCriteriaType::MIN_AMOUNT,
            LenderCriteriaType::MAX_AMOUNT,
            LenderCriteriaType::MIN_TENOR,
            LenderCriteriaType::MAX_TENOR
        ];

        foreach ($types as $type) {
            $criterias = app(GetLenderCriteriaByTypeTask::class)->run($type)->toArray();

            foreach ($criterias as $criteria) {
                $value = $criteria['value'];
                $actualValue = null;

                if ($type == LenderCriteriaType::MIN_AMOUNT || $type == LenderCriteriaType::MAX_AMOUNT) {
                    $actualValue = changeMoneyFormat($value)[0];
                } else {
                    [$valueNum, $valueTxt] = explode( ' ', $value);
                    switch ($valueTxt) {
                        case 'months':
                            $actualValue = (int)$valueNum;
                            break;
                        case 'years':
                            $actualValue = (int)$valueNum * 12;
                            break;
                    }
                }

                \DB::table('lender_criteria')
                    ->where('id', $criteria['id'])
                    ->update(['actual_value' => $actualValue]);
            }
        }
    }
}
