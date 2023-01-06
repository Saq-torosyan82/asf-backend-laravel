<?php

namespace App\Containers\AppSection\System\UI\API\Transformers;

use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Containers\AppSection\System\Models\SportLeague;
use App\Ship\Parents\Transformers\Transformer;

class SportLeagueTransformer extends Transformer
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

    public function transform(SportLeague $sportleague): array
    {
        $response = [
            'id' => $sportleague->getHashedKey(),
            'sport_id' => $sportleague->Sport->getHashedKey(),
            'name' => $sportleague->name,
            'level' => $sportleague->level,
            'logo' => $this->getLogo($sportleague)
        ];

        return $response = $this->ifAdmin([
            'real_id' => $sportleague->id,
        ], $response);
    }

    private function getLogo($sportleague)
    {
        if ($sportleague->logo) {
            return route(
                'web_system_logo_asset',
                [LogoAssetType::getLogoPath(LogoAssetType::SPORT_LEAGUE), $sportleague->logo]
            );
        }

        return LogoAssetType::getDetaultLogo(LogoAssetType::SPORT_LEAGUE);
    }
}
