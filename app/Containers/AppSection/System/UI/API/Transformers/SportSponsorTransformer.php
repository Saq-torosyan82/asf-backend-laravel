<?php

namespace App\Containers\AppSection\System\UI\API\Transformers;

use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Containers\AppSection\System\Models\SportSponsor;
use App\Ship\Parents\Transformers\Transformer;

class SportSponsorTransformer extends Transformer
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

    public function transform(SportSponsor $sportsponsor): array
    {
        if ($sportsponsor->logo) {
            $logo = route(
                'web_system_logo_asset',
                [LogoAssetType::getLogoPath(LogoAssetType::SPORT_SPONSOR), $sportsponsor->logo]
            );
        } else {
            $logo = LogoAssetType::getDetaultLogo(LogoAssetType::SPORT_SPONSOR);
        }

        return [
            'id' => $sportsponsor->getHashedKey(),
            'name' => $sportsponsor->name,
            'logo' => $logo
        ];
    }
}
