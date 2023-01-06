<?php

namespace App\Containers\AppSection\Deal\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class InterestRateRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        'entity_type' => '=',
        'entity_id' => '=',
    ];
}
