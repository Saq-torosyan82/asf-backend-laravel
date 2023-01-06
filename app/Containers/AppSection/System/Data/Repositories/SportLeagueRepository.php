<?php

namespace App\Containers\AppSection\System\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class SportLeagueRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        'sport_id' => '=',
        'SportClubs.country_id' => '='
    ];
}
