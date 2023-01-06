<?php

namespace App\Containers\AppSection\Deal\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Deal\Enums\ContractType;
use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;
use App\Containers\AppSection\System\Data\Repositories\SportClubRepository;
use Illuminate\Support\Facades\Log;

class GetCounterpartyLogoTask extends Task
{
    use HashIdTrait;

    protected SportClubRepository $clubRepository;

    public function __construct(SportClubRepository $repository)
    {
        $this->clubRepository = $repository;
    }

    public function run($deal)
    {
        $avatar = '';
        $key = 'club';
        if ($deal->contract_type == ContractType::MEDIA_RIGHTS) {
            $key = 'tvHolder';
        } elseif ($deal->contract_type == ContractType::ENDORSEMENT) {
            $key = 'sponsorOrBrand';
        }

        if ($key == 'club') {
            if (!isset($deal->criteria_data[$key]) || !isset($deal->criteria_data[$key]['id'])) {
                return '';
            }

            $club = $this->clubRepository->where('id',$deal->criteria_data[$key]['id'])->first();

            if (is_null($club)) {
                return '';
            }

            $avatar = $club->logo;

            if($avatar)
            {
                return route(
                    'web_system_logo_asset',
                    [LogoAssetType::getLogoPath(LogoAssetType::SPORT_CLUB), $avatar]
                );
            }
        }

        if (isset($deal->criteria_data[$key]) && isset($deal->criteria_data[$key]['logo'])) {
            $avatar = $deal->criteria_data[$key]['logo'];
        }

        if(!$avatar)
        {
            return LogoAssetType::getDetaultLogo(LogoAssetType::SPORT_CLUB);
        }

        return $avatar;
    }
}
