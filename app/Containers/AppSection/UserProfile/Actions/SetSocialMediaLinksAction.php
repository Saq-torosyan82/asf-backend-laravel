<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Financial\Enums\FactSectionsName;
use App\Containers\AppSection\Financial\Tasks\GetFactsByClubAndNameIdsTask;
use App\Containers\AppSection\System\Data\Repositories\SportBrandRepository;
use App\Containers\AppSection\System\Data\Repositories\SportSponsorRepository;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Tasks\CreateUserProfileTask;
use App\Ship\Parents\Actions\Action;

class SetSocialMediaLinksAction extends Action
{
    protected SportSponsorRepository $sportSponsorRepository;
    protected SportBrandRepository $sportBrandRepository;

    public function __construct(SportSponsorRepository $sportSponsorRepository, SportBrandRepository $sportBrandRepository)
    {
        $this->sportSponsorRepository = $sportSponsorRepository;
        $this->sportBrandRepository = $sportBrandRepository;
    }

    public function run($userId, $club_id): void
    {
        $factsIds = FactSectionsName::socialMediaFactsIds();

        $facts = app(GetFactsByClubAndNameIdsTask::class)->run($club_id, $factsIds);

        foreach ($facts as $fact) {
            if (strlen($fact->value) <= 1) {
                continue;
            }
            $explodedFact = explode(',', $fact->value);
            foreach ($explodedFact as $value) {
                $value = trim($value);
                app(CreateUserProfileTask::class)->run(
                    $userId,
                    FactSectionsName::getSocialMediaKeyById($fact->fact_name_id),
                    Group::SOCIAL_MEDIA,
                    $value
                );
            }
        }
    }
}
