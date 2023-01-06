<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Containers\AppSection\UserSponsorship\Enums\Key;
use App\Containers\AppSection\UserSponsorship\Tasks\GetAllClubSponsorsTask;
use App\Ship\Parents\Actions\Action;

class GetAllClubSponsorsAction extends Action
{
    public function run(): array
    {
        $sponsors = app(GetAllClubSponsorsTask::class)->run();
        $formatedSponsors = [];
        foreach ($sponsors as $sponsor) {
            $formatedSponsors[] = [
                'id' => $sponsor->getHashedKey(),
                'logo' => $this->getLogo($sponsor),
                'name' => $sponsor->name,
            ];
        }

        return [
            'sponsors' => $formatedSponsors,
            'types' => Key::mapClubSponsorKeys()
        ];
    }

    private function getLogo($sponsor)
    {
        if ($sponsor->logo) {
            return route(
                'web_system_logo_asset',
                [LogoAssetType::getLogoPath(LogoAssetType::SPORT_SPONSOR), $sponsor->logo]
            );
        }

        return LogoAssetType::getDetaultLogo(LogoAssetType::SPORT_SPONSOR);
    }
}
