<?php

namespace App\Containers\AppSection\System\UI\API\Transformers;

use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Containers\AppSection\System\Models\TvRightsHolder;
use App\Ship\Parents\Transformers\Transformer;

class TvRightsHolderTransformer extends Transformer
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

    public function transform(TvRightsHolder $tvrightsholder): array
    {

        if ($tvrightsholder->logo) {
            $logo = route(
                'web_system_logo_asset',
                [LogoAssetType::getLogoPath(LogoAssetType::TV_RIGHT), $tvrightsholder->logo]
            );
        }
        else{
            $logo = LogoAssetType::getDetaultLogo(LogoAssetType::TV_RIGHT);
        }

        return [
            'id' => $tvrightsholder->getHashedKey(),
            'name' => $tvrightsholder->name,
            'logo' => $logo
        ];
    }
}
