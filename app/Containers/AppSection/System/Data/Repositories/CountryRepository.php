<?php

namespace App\Containers\AppSection\System\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class CountryRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        'clubs.league.sport_id' => '='
    ];
}
