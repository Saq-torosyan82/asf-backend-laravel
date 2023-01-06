<?php

namespace App\Containers\AppSection\Financial\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Financial\Data\Repositories\FactNameRepository;
use App\Containers\AppSection\Financial\Enums\FactSectionsType;
use App\Containers\AppSection\System\Enums\LogoAssetType;
use App\Ship\Parents\Tasks\Task;

class GetHonoursWonTask extends Task
{
    use HashIdTrait;
    protected FactNameRepository $factNameRepository;

    public function __construct(FactNameRepository $factNameRepository)
    {
        $this->factNameRepository = $factNameRepository;
    }

    public function run($club)
    {
        $data = [];
        $allHonours = [];
        $labels = [
            'National Cup' => [
                'England' => ['fa_cup.png', 'efl_cup.png'],
                'Germany' => ['dfb-pokal.png'],
                'Italy' => ['coppa_italia.png'],
                'Spain' => ['copa_del_rey.png'],
                'France' => ['coupe_de_france.png'],
            ],
            'Champions League' => 'champinos_league.png',
            'Europa Leagues' => 'europa_league.png',
            'Europa Conference' => 'europa_conference.png',
        ];

        $res = app(GetFactsBySectionIdTask::class)->run($this->decode($club['id']),  FactSectionsType::getId(FactSectionsType::MAIN_CLUB_HONOURS));
        foreach ($res as $row) {
            if ($row['value'] > 0) {
                if ($row['name'] == 'League Titles') {
                    $data[] = $club['league']['logo'];
                } else {
                    $key = array_key_exists($row['name'], $labels);
                    if ($key !== false) {
                        if (is_array($labels[$row['name']]) && array_key_exists($club['country'],$labels[$row['name']])) {
                            foreach ($labels[$row['name']][$club['country']] as $item) {
                                $data[] = $this->getLogo(LogoAssetType::CLUB_HONOURS, $item);
                            }
                        } else {
                            $allHonours[] = $this->getLogo(LogoAssetType::CLUB_HONOURS, $labels[$row['name']]);
                        }
                    }
                }
            }
        }
        if (!empty($allHonours)) {
            $data[] = $allHonours;
        }
        return $data;
    }

    /**
     * @param $type
     * @param $logo
     * @return string
     */
    private function getLogo($type, $logo)
    {
        if ($logo) {
            return route(
                'web_system_logo_asset',
                [LogoAssetType::getLogoPath($type), $logo]
            );
        }

        return LogoAssetType::getDetaultLogo($type);
    }

}
