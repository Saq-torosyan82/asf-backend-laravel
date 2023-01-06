<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\Financial\Enums\FactSectionsName;
use App\Containers\AppSection\Financial\Tasks\GetFactsByClubAndNameIdsTask;
use App\Containers\AppSection\System\Data\Repositories\SportBrandRepository;
use App\Containers\AppSection\System\Data\Repositories\SportSponsorRepository;
use App\Containers\AppSection\System\Tasks\GetSystemDataByNameTask;
use App\Containers\AppSection\UserSponsorship\Enums\Key;
use App\Containers\AppSection\UserSponsorship\Tasks\CreateClubSponsorTask;
use App\Containers\AppSection\UserSponsorship\Tasks\CreateUserSponsorshipTask;
use App\Containers\AppSection\UserSponsorship\Tasks\GetClubSponsorByNameTask;
use App\Ship\Parents\Actions\Action;

class SetClubSponsorsAction extends Action
{

    protected SportSponsorRepository $sportSponsorRepository;
    protected SportBrandRepository $sportBrandRepository;

    public function __construct(SportSponsorRepository $sportSponsorRepository, SportBrandRepository $sportBrandRepository)
    {
        $this->sportSponsorRepository = $sportSponsorRepository;
        $this->sportBrandRepository = $sportBrandRepository;
    }

    public function run(int $user_id, $club_id): void
    {
        $factsIds = FactSectionsName::clubFactsIds();

        $facts = app(GetFactsByClubAndNameIdsTask::class)->run($club_id, $factsIds);

        foreach ($facts as $fact) {
            if (strlen($fact->value) >= 2) {
                $explodedFact = explode(',', $fact->value);
                foreach ($explodedFact as $value) {
                    $value = trim($value);
                    $sponsorClub = app(GetClubSponsorByNameTask::class)->run($value);
                    if ($sponsorClub) {
                        app(CreateUserSponsorshipTask::class)->run($user_id, Key::getTypeById($fact->fact_name_id), $sponsorClub->id);
                    } else {
                        $sponsor = app(GetSponsorOrBrandByNameSubAction::class)->run($value);
                        $sponsorClub = app(CreateClubSponsorTask::class)->run([
                            'name' => $value,
                            'logo' => $sponsor ? $sponsor->logo : null
                        ]);
                        if ($sponsorClub) {
                            app(CreateUserSponsorshipTask::class)->run($user_id, Key::getTypeById($fact->fact_name_id), $sponsorClub->id);
                        }
                    }
                }
            }
        }
    }
}
