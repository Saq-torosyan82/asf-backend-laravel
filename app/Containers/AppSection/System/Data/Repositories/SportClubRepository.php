<?php

namespace App\Containers\AppSection\System\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class SportClubRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        'league_id' => '=',
        'country_id' => '=',
        'sport_id' => '=',
        'league.sport_id' => '=',
    ];
}
