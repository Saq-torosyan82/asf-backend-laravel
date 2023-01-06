<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Financial\Enums\FactSectionsName;
use App\Containers\AppSection\Financial\Tasks\GetFactsByClubAndNameIdsTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Tasks\CreateUserProfileTask;
use App\Ship\Parents\Actions\Action;

class ImportUserProfileDataFromFactsDataAction extends Action
{
    public function run(int $userId, $club_id, array $factsIds)
    {
        $facts = app(GetFactsByClubAndNameIdsTask::class)->run($club_id, $factsIds);

        foreach ($facts as $fact) {
            if (strlen($fact->value) <= 1) {
                continue;
            }

            $key = FactSectionsName::getStadiumKeyById($fact->fact_name_id);
            app(CreateUserProfileTask::class)->run($userId, $key, Group::COMPANY, $fact->value);
        }// foreach
    }
}
