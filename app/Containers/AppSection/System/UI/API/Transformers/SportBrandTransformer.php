<?php

namespace App\Containers\AppSection\System\UI\API\Transformers;

use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Containers\AppSection\System\Models\SportBrand;
use App\Ship\Parents\Transformers\Transformer;

class SportBrandTransformer extends Transformer
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

    public function transform(SportBrand $sportbrand): array
    {
        if ($sportbrand->logo) {
            $logo = route(
                'web_system_logo_asset',
                [LogoAssetType::getLogoPath(LogoAssetType::SPORT_BRAND), $sportbrand->logo]
            );
        } else {
            $logo = LogoAssetType::getDetaultLogo(LogoAssetType::SPORT_BRAND);
        }

        $response = [
            'id' => $sportbrand->getHashedKey(),
            'name' => $sportbrand->name,
            'logo' => $logo
        ];

        return $response;
    }
}
