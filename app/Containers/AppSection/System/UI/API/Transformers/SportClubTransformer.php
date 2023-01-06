<?php

namespace App\Containers\AppSection\System\UI\API\Transformers;

use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Containers\AppSection\System\Models\SportClub;
use App\Ship\Parents\Transformers\Transformer;

class SportClubTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    public function transform(SportClub $sportclub): array
    {
        $league = null;
        if ($sportclub->league_id) {
            $league = $sportclub->League->getHashedKey();
        }
        $sport = null;
        if ($sportclub->sport_id) {
            $sport = $sportclub->sport->getHashedKey();
        }
        $country = null;
        if ($sportclub->country_id) {
            $country = $sportclub->Country->getHashedKey();
        }
        return [
            'id' => $sportclub->getHashedKey(),
            'league_id' => $league,
            'country_id' => $country,
            'sport_id' => $sport,
            'name' => $sportclub->name,
            'logo' => $this->getLogo($sportclub),
        ];
    }

    private function getLogo($sportclub)
    {
        if ($sportclub->logo) {
            return route(
                'web_system_logo_asset',
                [LogoAssetType::getLogoPath(LogoAssetType::SPORT_CLUB), $sportclub->logo]
            );
        }

        return LogoAssetType::getDetaultLogo(LogoAssetType::SPORT_CLUB);
    }
}
